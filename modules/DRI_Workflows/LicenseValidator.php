<?php

namespace DRI_Workflows;

use DRI_Workflows\Exception\InvalidLicenseException;
use DRI_Workflows\Exception\UserNotAuthorizedException;

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class LicenseValidator
{
    const KEY_VALID_UNTIL = 'valid_until';
    const KEY_NUMBER_OF_USERS = 'number_of_users';
    const KEY_LICENSE = 'license_key';
    const KEY_APPLICATION = 'application';

    /**
     * @var int
     */
    private static $currentUsers;

    /**
     * @var string
     */
    private $labelName = 'CUSTOMER_JOURNEY';

    /**
     * @var string
     */
    private $licenseAboutToExpireWarningInterval = '- 2 weeks';

    /**
     * @var string
     */
    private $notificationInterval = '- 2 days';

    /**
     * @var \DBManager
     */
    private $db;

    /**
     * @var \TimeDate
     */
    private $timeDate;

    /**
     * @var string
     */
    private $application;

    /**
     * @var string
     */
    private $licenseKey;

    /**
     * @var string
     */
    private $validationKeyEncrypted;

    /**
     * @var string
     */
    private $validationKey;

    /**
     * @var array
     */
    private $requiredKeys = array (
        self::KEY_LICENSE,
        self::KEY_APPLICATION,
        self::KEY_VALID_UNTIL,
        self::KEY_NUMBER_OF_USERS,
    );

    /**
     * @param string $application
     * @param string $licenseKey
     * @param string $validationKey
     */
    public function __construct($application, $licenseKey, $validationKey)
    {
        $this->application = $application;
        $this->licenseKey = $licenseKey;
        $this->validationKeyEncrypted = $validationKey;

        $this->db = \DBManagerFactory::getInstance();
        $this->timeDate = \TimeDate::getInstance();
    }

    /**
     * @throws \DRI_Workflows\Exception\InvalidLicenseException
     * @throws \SugarApiException
     */
    public function validateKey()
    {
        $this->decrypt();
        $this->checkValidationKey();
        $this->checkLicenseKey();
        $this->checkApplication();
        $this->checkExpired();
        $this->checkUserLimit();
        $this->checkAboutToExpire();
    }

    /**
     * @throws \DRI_Workflows\Exception\InvalidLicenseException
     */
    public function validateCurrentUser()
    {
        global $current_user;

        if (empty($current_user->customer_journey_access)) {
            throw new UserNotAuthorizedException($this->createLabel('ERROR_USER_MISSING_ACCESS'));
        }
    }

    /**
     * @throws \SugarApiException
     */
    private function checkLicenseKey()
    {
        if ($this->licenseKey !== $this->validationKey[self::KEY_LICENSE]) {
            $this->throwError('ERROR_INVALID_LICENSE_KEY');
        }
    }

    /**
     *
     */
    private function checkApplication()
    {
        if ($this->application !== $this->validationKey[self::KEY_APPLICATION]) {
            $this->throwError('ERROR_INVALID_APPLICATION_LICENSE_KEY');
        }
    }

    /**
     *
     */
    private function checkUserLimit()
    {
        $currentNumberOfUsers = $this->getCurrentUsers();
        $userLimit = $this->getUserLimit();

        if ($currentNumberOfUsers > $userLimit) {
            $this->createNotification(
                translate($this->createLabel('USER_LIMIT_REACHED_NAME')),
                string_format(
                    translate($this->createLabel('USER_LIMIT_REACHED_DESCRIPTION')),
                    array ($userLimit)
                )
            );

            $this->throwError('ERROR_LICENSE_KEY_USER_LIMIT_REACHED');
        }
    }

    /**
     * @param string $name
     * @return string
     */
    private function createLabel($name)
    {
        return 'LBL_' . $this->labelName . '_' . $name;
    }

    /**
     *
     */
    private function checkAboutToExpire()
    {
        $now = $this->getNow();
        $validUntil = $this->getValidUntil();
        $licenseAboutToExpireWarning = $this->getLicenseAboutToExpireWarningDate();

        if ($now->getTimestamp() > $licenseAboutToExpireWarning->getTimestamp()) {
            $this->createNotification(
                translate($this->createLabel('LICENSE_ABOUT_TO_EXPIRE_NAME')),
                string_format(
                    translate($this->createLabel('LICENSE_ABOUT_TO_EXPIRE_DESCRIPTION')),
                    array ($this->timeDate->asUserDate($validUntil))
                )
            );
        }
    }

    /**
     * @return \DateTime
     */
    private function getLicenseAboutToExpireWarningDate()
    {
        $licenseAboutToExpireWarning = $this->getValidUntil();
        $licenseAboutToExpireWarning->modify($this->licenseAboutToExpireWarningInterval);
        return $licenseAboutToExpireWarning;
    }

    /**
     * @return \DateTime
     */
    private function getNotificationDate()
    {
        $notificationDate = $this->timeDate->getNow();
        $notificationDate->modify($this->notificationInterval);
        return $notificationDate;
    }

    /**
     * @param string $name
     * @param string $description
     */
    private function createNotification($name, $description)
    {
        $notificationDate = $this->getNotificationDate();

        foreach ($this->getAdminUserIds() as $userId) {
            $sql = <<<SQL
              SELECT id
              FROM notifications
              WHERE assigned_user_id = '%s'
                AND name = '%s'
                AND deleted = 0
                AND date_entered >= '%s'
SQL;
            $sql = sprintf($sql, $userId, $name, $this->timeDate->asDb($notificationDate));

            $notificationId = $this->db->getOne($sql, true);

            if (empty($notificationId)) {
                /** @var \Notifications $notification */
                $notification = \BeanFactory::newBean('Notifications');
                $notification->name = $name;
                $notification->description = $description;
                $notification->assigned_user_id = $userId;
                $notification->severity = 'warning';
                $notification->save();
            }
        }
    }

    /**
     * @return array
     */
    private function getAdminUserIds()
    {
        $sql = <<<SQL
            SELECT id
            FROM users u
            WHERE u.is_admin = 1
              AND u.deleted = 0
SQL;

        $ids = array ();

        $result = \DBManagerFactory::getInstance()->query($sql, true);

        while ($row = $this->db->fetchByAssoc($result)) {
            $ids[] = $row['id'];
        }

        return $ids;
    }

    /**
     *
     */
    private function decrypt()
    {
        if (null !== $this->validationKey) {
            return;
        }

        if (empty($this->validationKeyEncrypted)) {
            $this->throwError('ERROR_MISSING_VALIDATION_KEY');
        }

        $validationKey = base64_decode($this->validationKeyEncrypted);

        if (empty($validationKey)) {
            $this->throwError('ERROR_CORRUPT_VALIDATION_KEY');
        }

        $validationKey = unserialize($validationKey);

        if (!is_array($validationKey)) {
            $this->throwError('ERROR_CORRUPT_VALIDATION_KEY');
        }

        $this->validationKey = $validationKey;
    }

    /**
     * @param string $label
     * @throws InvalidLicenseException
     */
    private function throwError($label)
    {
        throw new InvalidLicenseException($this->createLabel($label));
    }

    /**
     *
     */
    private function checkExpired()
    {
        $now = $this->getNow();
        $validUntil = $this->getValidUntil();

        if ($now->getTimestamp() > $validUntil->getTimestamp()) {
            $this->throwError('ERROR_LICENSE_KEY_EXPIRED');
        }
    }

    /**
     * @throws \SugarApiException
     */
    private function checkValidationKey()
    {
        foreach ($this->requiredKeys as $index) {
            if (empty($this->validationKey[$index])) {
                $this->throwError('ERROR_LICENSE_KEY_MISSING_INFO');
            }
        }
    }

    /**
     * @return \DateTime
     */
    private function getNow()
    {
        $now = $this->timeDate->getNow();
        $now->setTime(0, 0, 0);
        return $now;
    }

    /**
     * @return \DateTime
     */
    public function getValidUntil()
    {
        $this->decrypt();
        $validUntil = $this->timeDate->fromDbDate($this->validationKey[self::KEY_VALID_UNTIL]);
        $validUntil->setTime(0, 0, 0);
        return $validUntil;
    }

    /**
     * @return int
     */
    public function getCurrentUsers()
    {
        if (null === self::$currentUsers) {
            require_once 'modules/Users/User.php';
            $sql = 'SELECT count(id) FROM users WHERE customer_journey_access = 1 AND '.\User::getLicensedUsersWhere();
            self::$currentUsers = $this->db->getOne($sql, true);
        }

        return self::$currentUsers;
    }

    /**
     * @return mixed
     */
    public function getUserLimit()
    {
        $this->decrypt();
        return $this->validationKey[self::KEY_NUMBER_OF_USERS];
    }
}

<?php


class CustomPMSEEmailHandler extends PMSEEmailHandler {

    private $beanUtils;
    private $logger;

    public function __construct() {
        parent::__construct();
        $this->beanUtils = parent::getBeanUtils();
        $this->logger = parent::getLogger();
    }

    public function sendTemplateEmail($moduleName, $beanId, $addresses, $templateId) {
        $mailTransmissionProtocol = "unknown";
        try {

            $bean = $this->retrieveBean($moduleName, $beanId);

            $templateObject = $this->retrieveBean('pmse_Emails_Templates');
            $templateObject->disable_row_level_security = true;
            //custom code to send email from process author through the outbound email of the assign user
            $user = $this->getCurrentAssignee($bean);           
            $statusCode = OutboundEmailConfigurationPeer::getMailConfigurationStatusForUser($user);
            if ($statusCode != OutboundEmailConfigurationPeer::STATUS_VALID_CONFIG) {
                $mailObject = $this->retrieveMailer();
            } else {

                $mailObject = MailerFactory::getMailerForUser($user);
            }
            //end of custom code
            $mailTransmissionProtocol = $mailObject->getMailTransmissionProtocol();

            $this->addRecipients($mailObject, $addresses);

            if (isset($templateId) && $templateId != "") {
                $templateObject->retrieve($templateId);
            } else {
                $this->logger->warning('template_id is not defined');
            }

            if (!empty($templateObject->from_name) && !empty($templateObject->from_address)) {
                $mailObject->setHeader(EmailHeaders::From, new EmailIdentity($templateObject->from_address, $templateObject->from_name));
            }

            if (isset($templateObject->body) && empty($templateObject->body)) {
                $templateObject->body = strip_tags(from_html($templateObject->body_html));
            } else {
                $this->logger->warning('template body is not defined');
            }

            if (!empty($templateObject->body) && !empty($templateObject->body_html)) {
                $textOnly = EmailFormatter::isTextOnly($templateObject->body_html);
                if (!$textOnly) {
                    if (!empty($templateObject->body_html)) {
                        //set HTMLBody
                        $htmlBody = from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->body_html));
                        $mailObject->setHtmlBody($htmlBody);
                    }
                }
                // set TextBody too
                $textBody = strip_tags(br2nl($templateObject->body));
                $mailObject->setTextBody($textBody);
            } else {
                $this->logger->warning('template body_html is not defined');
            }

            if (isset($templateObject->subject)) {
                $mailObject->setSubject(from_html($this->beanUtils->mergeBeanInTemplate($bean, $templateObject->subject)));
            } else {
                $this->logger->warning('template subject is not defined');
            }

            $mailObject->send();
        } catch (MailerException $mailerException) {
            $message = $mailerException->getMessage();
            $this->logger->warning("Error sending email (method: {$mailTransmissionProtocol}), (error: {$message})");
        }
    }

}

-- Your installation or use of this SugarCRM file is subject to the applicable
-- terms available at
-- http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
-- If you do not agree to all of the applicable terms or do not have the
-- authority to bind the entity as an authorized representative, then do not
-- install or use this SugarCRM file.
--
-- Copyright (C) SugarCRM Inc. All rights reserved.

-- a password of user1 is user1pass, user2's password is user2pass, etc.

INSERT INTO `users` (`id`, `username`, `password`, `created`, `modified`, `deleted`) VALUES
  ('6f1f6421-6a77-409d-8a59-76308ee399df', 'user1', '$2y$10$XZqRv/2rA56qz/Y/Sw1D9.021038DkyqXQkkrIeukWvePD4YKcV8y', NOW(), NOW(), 0),
  ('6b0d13f2-aeb4-4a7e-ba38-a0cf44640499', 'user2', '$2y$10$MdbT1ouox0b01cUspLHGseO6s60CN6sYvHGQl2j.hoyDoDawHKegq', NOW(), NOW(), 0),
  ('bbea1845-d6a1-477b-bffe-370174f01710', 'user3', '$2y$10$KOw.QgPGGcmDZ3vBBRbNTe3/F5xHPAadfhvg4hsrG/tN8CrJTeWES', NOW(), NOW(), 1),
  ('e842d2e5-cc5f-4876-93fb-a478ba451afe', 'user4', '$2y$10$bgsdeIMU6zvefbo9PAdhzOxu.EZW0X9i7TGidJf8P2JJQ3YKkpDHK', NOW(), NOW(), 0),
  ('3b678759-d906-4bab-9d2e-78d4a4fdc025', 'user5', '$2y$10$MpWZ02kHzd93vblFBFT.Tu74d1tAj3MSpZIrkfZAu5/MWxDimnT/y', NOW(), NOW(), 0),
  ('1aa16947-9d38-4b4e-8204-331e421fb432', 'user6', '$2y$10$nCF6AsdPzvyocP2ynoCgUeXlmlpx2ldc1VfNiFSFy1/UGR8btnYCi', NOW(), NOW(), 1),
  ('14acb450-5292-42e4-9c41-dd864cce01ac', 'user7', '$2y$10$QE7XRFHgfb.OItUMz15yg./OqC1mHxh4NAz9nsy9nvX97e.0eM19O', NOW(), NOW(), 0),
  ('5f4e765c-60cc-4a28-b8bb-7f620258c875', 'user8', '$2y$10$LYVZ69PzYq4PzyRu4HDa2O5QFFhaUXYnGfF494d3mZ1m5DKtxT7qy', NOW(), NOW(), 0),
  ('aff20d60-c4b7-45d3-abae-008f5e46cb0a', 'user9', '$2y$10$LQXh7zSYaoPmTjboRYSHEOykYtluL1u4iuwjOqFf.AArvS4XAtBFG', NOW(), NOW(), 1),
  ('6efcf62d-35af-419a-8c2f-bb2b494de003', 'user10', '$2y$10$J9J81Pxu2lmrRawGVKj73OOd.QREqBVb2w6sPPQrS1tx88.YDV3P6', NOW(), NOW(), 0)
;

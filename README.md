# HubBox - Enterprise Hub and Web Product Manager

[![](https://data.jsdelivr.com/v1/package/gh/3m1n3nc3/ourzobia-api/badge)](https://www.jsdelivr.com/package/gh/3m1n3nc3/ourzobia-api)

**HubBox - Enterprise Hub and Web Product Manager** is a business hub or office space booking and web product validation and activation platform, that will help you protect your **PHP, NODE JS, ASP.net script codes** and potentially anything that needs a web browser to run from unauthorized use and theft and also enables you manage and allow customers to make **online bookings** for your business hubs and rented office facilities.
This is perfect for you if you have script **codes distributed via online marketplaces**, and would require that customers who purchase 
your scripts enter an **activation code**, before they are able to use the product and also if you own business hubs and office facilities that you put out for daily rent and would need to allow customers book online and remotely.

**HubBox - Enterprise Hub and Web Product Manager** also allows you to generate and provide custom email addresses using Cpanel for your users and staff allowing them to send, read and manage email messages without leaving the system at a convenience never before seen, users can also login with one click to the webmail interface without the requirement to enter passwords.

#### Advantages of using HubBox
  1. The core is written on the latest version of the Codeigniter framework.
  2. Activation code is only valid for a single domain.
  3. Uses cookies to prevent frequent calls to the validation server.
  4. Can be hosted on Github and served via CDN.
  5. Validation is done outside the validating script, making it rather difficult to break.
  6. Frontend can be re-implemented with calls only made to the validation API.
  7. Can be used for B2B - B2C Validation by installing the B2B Plugin.
  8. Payments can be collected via credit cards with Stripe and Paystack.
  9. Reservations are automated and will activate or expire at the booked time frame.
  10. Booked Hubs can easily be verified with a simple qr-code scan.


##### Documentation Content
1. **Introduction.**
 1. Requirements.
 2. Installation.
 3. License.

2. **Product Validation and Activation.**
 1. Basic Implementation.
 2. API Endpoints.
 3. Product Activation and Validations.
    1. Setup Product.
    2. Adding a new product.
    3. Updating a product.
    4. Listing products.
    5. Activating and Validating a product. 

3. **Cpanel and AfterLogic Webmails.**
 1. Setup Webmail.
 2. Installing AfterLogic Webmmail.
 3. Create Email addresses.
 4. Login to Webmail/AfterLogic Webmail.
 5. Delete Webmail Account.

4. **Mailbox.**
 1. List and Manage Mail.
 2. Read Mail.
 3. Compose Message.

5. **Hubs and office management.**
 1. Manage Hub Categories.
 2. Manage Hubs.
 3. Book Hubs.
 4. View Booked Hubs.

6. **System Management**
 1. Configuration.
 2. Cron Jobs. 
 3. Installing Updates.

7. **Features.**


Update Queries
ALTER TABLE `all_products` ADD `license_type` VARCHAR(128) NULL DEFAULT NULL AFTER `name`;
ALTER TABLE `all_products` ADD `expiry` VARCHAR(128) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `analytics` ADD `response` INT NOT NULL DEFAULT '1' AFTER `referrer`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `licenses` text COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `date` int DEFAULT NULL,
  `updated` int DEFAULT NULL,
  `deleted` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `product_updates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL,
  `pid` int NOT NULL,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `date` int DEFAULT NULL,
  `updated` int DEFAULT NULL,
  `deleted` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

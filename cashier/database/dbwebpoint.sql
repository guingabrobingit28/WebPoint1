-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2023 at 03:12 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbwebpoint`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmininfo`
--

CREATE TABLE `tbladmininfo` (
  `admin_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `admin_lastname` varchar(35) NOT NULL,
  `admin_firstname` varchar(35) NOT NULL,
  `admin_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbladmininfo`:
--   `user_id`
--       `tbluseraccount` -> `User_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaudittrail`
--

CREATE TABLE `tblaudittrail` (
  `audittrail_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `audit_date` date NOT NULL,
  `audit_time` time NOT NULL,
  `audit_event` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblaudittrail`:
--   `user_id`
--       `tbluseraccount` -> `User_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(25) NOT NULL,
  `category_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblcategory`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomerinfo`
--

CREATE TABLE `tblcustomerinfo` (
  `customer_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `customer_type` varchar(15) NOT NULL,
  `customer_lastname` varchar(35) NOT NULL,
  `customer_firstname` varchar(35) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `customer_contact_no` varchar(13) NOT NULL,
  `customer_sex` varchar(7) NOT NULL,
  `customer_st_address` text NOT NULL,
  `customer_barangay` varchar(35) NOT NULL,
  `customer_municipality` varchar(35) NOT NULL,
  `customer_region` varchar(20) NOT NULL,
  `customer_provice` varchar(35) NOT NULL,
  `customer_zipcode` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblcustomerinfo`:
--   `user_id`
--       `tbluseraccount` -> `User_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomerorders`
--

CREATE TABLE `tblcustomerorders` (
  `customer_order_id` int(11) NOT NULL,
  `customer_type` varchar(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblcustomerorders`:
--   `customer_id`
--       `tblcustomerinfo` -> `customer_id`
--   `inventory_id`
--       `tblinventory` -> `inventory_id`
--   `product_id`
--       `tblproductinfo` -> `product_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomertransactionapp`
--

CREATE TABLE `tblcustomertransactionapp` (
  `customer_trans_app` int(10) NOT NULL,
  `customer_type` varchar(15) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `service_id` int(10) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblcustomertransactionapp`:
--   `customer_id`
--       `tblcustomerinfo` -> `customer_id`
--   `service_id`
--       `tblmaintenanceservice` -> `Service_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomertransactionorder`
--

CREATE TABLE `tblcustomertransactionorder` (
  `customer_trans_ord_id` int(11) NOT NULL,
  `customer_order_id` int(11) NOT NULL,
  `customer_type` varchar(15) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `discount` float NOT NULL,
  `delivery_method_id` int(11) NOT NULL,
  `delivery_fee` float NOT NULL,
  `payment_amount` float NOT NULL,
  `total_amount` float NOT NULL,
  `customer_change` float NOT NULL,
  `transorder_date` date NOT NULL,
  `transorder_time` time NOT NULL,
  `transorder_status_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `mode_of_transaction` varchar(25) NOT NULL,
  `proof_payment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblcustomertransactionorder`:
--   `customer_id`
--       `tblcustomerinfo` -> `customer_id`
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--   `delivery_method_id`
--       `tbldelivermethod` -> `deliver_method_id`
--   `proof_payment_id`
--       `tblproofpayment` -> `proof_payment_id`
--   `transorder_status_id`
--       `tbltransorderstatus` -> `transorder_status_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbldelivermethod`
--

CREATE TABLE `tbldelivermethod` (
  `deliver_method_id` int(10) NOT NULL,
  `deliver_method_name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbldelivermethod`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblexchangeproduct`
--

CREATE TABLE `tblexchangeproduct` (
  `customer_order_id` int(10) NOT NULL,
  `product_name_exc` varchar(35) NOT NULL,
  `quantity` int(10) NOT NULL,
  `return_date` date NOT NULL,
  `return_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblexchangeproduct`:
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblinventory`
--

CREATE TABLE `tblinventory` (
  `inventory_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `current_quantity` int(10) NOT NULL,
  `critical_value` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblinventory`:
--   `product_id`
--       `tblproductinfo` -> `product_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblmaintenanceservice`
--

CREATE TABLE `tblmaintenanceservice` (
  `Service_id` int(10) NOT NULL,
  `Service_Name` varchar(35) NOT NULL,
  `Service_Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblmaintenanceservice`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblnotificationadmin`
--

CREATE TABLE `tblnotificationadmin` (
  `notification_adm_id` int(10) NOT NULL,
  `notification_type_id` int(10) NOT NULL,
  `notify_date` date NOT NULL,
  `notify_time` time NOT NULL,
  `notify_name` varchar(35) NOT NULL,
  `notify_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblnotificationadmin`:
--   `notification_type_id`
--       `tblnotificationtype` -> `notification_type_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblnotificationappointment`
--

CREATE TABLE `tblnotificationappointment` (
  `notification_app_id` int(10) NOT NULL,
  `notification_type_id` int(10) NOT NULL,
  `notify_date` date NOT NULL,
  `notify_time` time NOT NULL,
  `notify_name` varchar(35) NOT NULL,
  `notify_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblnotificationappointment`:
--   `notification_type_id`
--       `tblnotificationtype` -> `notification_type_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblnotificationorder`
--

CREATE TABLE `tblnotificationorder` (
  `notification_ord_id` int(10) NOT NULL,
  `notification_type_id` int(10) NOT NULL,
  `notify_date` date NOT NULL,
  `notify_time` time NOT NULL,
  `notify_name` varchar(35) NOT NULL,
  `notify_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblnotificationorder`:
--   `notification_type_id`
--       `tblnotificationtype` -> `notification_type_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblnotificationtype`
--

CREATE TABLE `tblnotificationtype` (
  `notification_type_id` int(11) NOT NULL,
  `notification_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblnotificationtype`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblonlinesession`
--

CREATE TABLE `tblonlinesession` (
  `online_session_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `session_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblonlinesession`:
--   `user_id`
--       `tbluseraccount` -> `User_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblproductinfo`
--

CREATE TABLE `tblproductinfo` (
  `product_id` int(10) NOT NULL,
  `product_name` varchar(35) NOT NULL,
  `product_price` float NOT NULL,
  `product_status` varchar(15) NOT NULL,
  `product_img` blob NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL,
  `subcategory_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblproductinfo`:
--   `category_id`
--       `tblcategory` -> `category_id`
--   `subcategory_id`
--       `tblsubcategory` -> `Subategory_id`
--   `supplier_id`
--       `tblsupplierinfo` -> `Supplier_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblproductreturn`
--

CREATE TABLE `tblproductreturn` (
  `customer_order_id` int(10) NOT NULL,
  `product_name` varchar(35) NOT NULL,
  `quantity` int(10) NOT NULL,
  `product_proof_condition_img` blob NOT NULL,
  `return_statement` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblproductreturn`:
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblproofpayment`
--

CREATE TABLE `tblproofpayment` (
  `proof_payment_id` int(10) NOT NULL,
  `customer_order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `proof_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblproofpayment`:
--   `customer_id`
--       `tblcustomerinfo` -> `customer_id`
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblqrpayment`
--

CREATE TABLE `tblqrpayment` (
  `qrpayment_id` int(10) NOT NULL,
  `payment_name` varchar(35) NOT NULL,
  `payment_img` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblqrpayment`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblstockin`
--

CREATE TABLE `tblstockin` (
  `stockin_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `inventory_id` int(10) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `stock_qnty_receive` int(10) NOT NULL,
  `stockin_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblstockin`:
--   `inventory_id`
--       `tblinventory` -> `inventory_id`
--   `product_id`
--       `tblproductinfo` -> `product_id`
--   `supplier_id`
--       `tblsupplierinfo` -> `Supplier_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblsubcategory`
--

CREATE TABLE `tblsubcategory` (
  `Subategory_id` int(10) NOT NULL,
  `Subcategory_name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblsubcategory`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblsupplierinfo`
--

CREATE TABLE `tblsupplierinfo` (
  `Supplier_id` int(10) NOT NULL,
  `Supplier_name` varchar(35) NOT NULL,
  `Supplier_Contact_Number` varchar(13) NOT NULL,
  `Supplier_Address` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblsupplierinfo`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltermsandcondition`
--

CREATE TABLE `tbltermsandcondition` (
  `Terms_Condition_id` int(10) NOT NULL,
  `TC_Title` mediumtext NOT NULL,
  `TC_Information` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbltermsandcondition`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltrackorders`
--

CREATE TABLE `tbltrackorders` (
  `track_order_id` int(10) NOT NULL,
  `customer_order_id` int(10) NOT NULL,
  `mode_of_transaction` varchar(25) NOT NULL,
  `track_order_date` date NOT NULL,
  `track_order_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbltrackorders`:
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltransorderstatus`
--

CREATE TABLE `tbltransorderstatus` (
  `transorder_status_id` int(11) NOT NULL,
  `trans_order_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbltransorderstatus`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE `tbluseraccount` (
  `User_id` int(10) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(25) NOT NULL,
  `User_EmailAddress` varchar(50) NOT NULL,
  `User_Contact_Number` varchar(13) NOT NULL,
  `User_Position` varchar(15) NOT NULL,
  `Registration_Date` date NOT NULL,
  `user_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tbluseraccount`:
--

-- --------------------------------------------------------

--
-- Table structure for table `tblvoidorder`
--

CREATE TABLE `tblvoidorder` (
  `void_order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `customer_order_id` int(10) NOT NULL,
  `void_statement` longtext NOT NULL,
  `void_date` date NOT NULL,
  `void_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `tblvoidorder`:
--   `customer_id`
--       `tblcustomerinfo` -> `customer_id`
--   `customer_order_id`
--       `tblcustomerorders` -> `customer_order_id`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmininfo`
--
ALTER TABLE `tbladmininfo`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `useradmin` (`user_id`);

--
-- Indexes for table `tblaudittrail`
--
ALTER TABLE `tblaudittrail`
  ADD PRIMARY KEY (`audittrail_id`),
  ADD KEY `useraudittrail` (`user_id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tblcustomerinfo`
--
ALTER TABLE `tblcustomerinfo`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `customerinfouser` (`user_id`),
  ADD KEY `customer_type_id` (`customer_type`);

--
-- Indexes for table `tblcustomerorders`
--
ALTER TABLE `tblcustomerorders`
  ADD PRIMARY KEY (`customer_order_id`),
  ADD KEY `customerordtype` (`customer_type`),
  ADD KEY `customerordcustomid` (`customer_id`),
  ADD KEY `customerordrproduct` (`product_id`),
  ADD KEY `customerordinventory` (`inventory_id`);

--
-- Indexes for table `tblcustomertransactionapp`
--
ALTER TABLE `tblcustomertransactionapp`
  ADD PRIMARY KEY (`customer_trans_app`),
  ADD KEY `customtransappcustomtype` (`customer_type`),
  ADD KEY `customtransappcustom` (`customer_id`),
  ADD KEY `customtransappservice` (`service_id`);

--
-- Indexes for table `tblcustomertransactionorder`
--
ALTER TABLE `tblcustomertransactionorder`
  ADD PRIMARY KEY (`customer_trans_ord_id`),
  ADD KEY `customtransordcustomord` (`customer_order_id`),
  ADD KEY `customtransordcustomtype` (`customer_type`),
  ADD KEY `customtransordcustom` (`customer_id`),
  ADD KEY `customtransorddelivery` (`delivery_method_id`),
  ADD KEY `customtransordproof` (`proof_payment_id`),
  ADD KEY `customtransordtransordstat` (`transorder_status_id`);

--
-- Indexes for table `tbldelivermethod`
--
ALTER TABLE `tbldelivermethod`
  ADD PRIMARY KEY (`deliver_method_id`);

--
-- Indexes for table `tblexchangeproduct`
--
ALTER TABLE `tblexchangeproduct`
  ADD KEY `exchangeprocustomord` (`customer_order_id`);

--
-- Indexes for table `tblinventory`
--
ALTER TABLE `tblinventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `inventoryproduct` (`product_id`);

--
-- Indexes for table `tblmaintenanceservice`
--
ALTER TABLE `tblmaintenanceservice`
  ADD PRIMARY KEY (`Service_id`);

--
-- Indexes for table `tblnotificationadmin`
--
ALTER TABLE `tblnotificationadmin`
  ADD PRIMARY KEY (`notification_adm_id`),
  ADD KEY `notificationadmtype` (`notification_type_id`);

--
-- Indexes for table `tblnotificationappointment`
--
ALTER TABLE `tblnotificationappointment`
  ADD PRIMARY KEY (`notification_app_id`),
  ADD KEY `notificationapptype` (`notification_type_id`);

--
-- Indexes for table `tblnotificationorder`
--
ALTER TABLE `tblnotificationorder`
  ADD PRIMARY KEY (`notification_ord_id`),
  ADD KEY `notificationordtype` (`notification_type_id`);

--
-- Indexes for table `tblnotificationtype`
--
ALTER TABLE `tblnotificationtype`
  ADD PRIMARY KEY (`notification_type_id`);

--
-- Indexes for table `tblonlinesession`
--
ALTER TABLE `tblonlinesession`
  ADD PRIMARY KEY (`online_session_id`),
  ADD KEY `onlinesesuser` (`user_id`);

--
-- Indexes for table `tblproductinfo`
--
ALTER TABLE `tblproductinfo`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `productsupplier` (`supplier_id`),
  ADD KEY `productcategory` (`category_id`),
  ADD KEY `productsubcategory` (`subcategory_id`);

--
-- Indexes for table `tblproductreturn`
--
ALTER TABLE `tblproductreturn`
  ADD KEY `productreturncustomord` (`customer_order_id`);

--
-- Indexes for table `tblproofpayment`
--
ALTER TABLE `tblproofpayment`
  ADD PRIMARY KEY (`proof_payment_id`),
  ADD KEY `proofcustomorder` (`customer_order_id`),
  ADD KEY `proofcustom` (`customer_id`);

--
-- Indexes for table `tblqrpayment`
--
ALTER TABLE `tblqrpayment`
  ADD PRIMARY KEY (`qrpayment_id`);

--
-- Indexes for table `tblstockin`
--
ALTER TABLE `tblstockin`
  ADD PRIMARY KEY (`stockin_id`),
  ADD KEY `stockinproduct` (`product_id`),
  ADD KEY `stockininventory` (`inventory_id`),
  ADD KEY `stockinsupplier` (`supplier_id`);

--
-- Indexes for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  ADD PRIMARY KEY (`Subategory_id`);

--
-- Indexes for table `tblsupplierinfo`
--
ALTER TABLE `tblsupplierinfo`
  ADD PRIMARY KEY (`Supplier_id`);

--
-- Indexes for table `tbltermsandcondition`
--
ALTER TABLE `tbltermsandcondition`
  ADD PRIMARY KEY (`Terms_Condition_id`);

--
-- Indexes for table `tbltrackorders`
--
ALTER TABLE `tbltrackorders`
  ADD PRIMARY KEY (`track_order_id`),
  ADD KEY `trackcustomorder` (`customer_order_id`);

--
-- Indexes for table `tbltransorderstatus`
--
ALTER TABLE `tbltransorderstatus`
  ADD PRIMARY KEY (`transorder_status_id`);

--
-- Indexes for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  ADD PRIMARY KEY (`User_id`);

--
-- Indexes for table `tblvoidorder`
--
ALTER TABLE `tblvoidorder`
  ADD PRIMARY KEY (`void_order_id`),
  ADD KEY `voidordcustom` (`customer_id`),
  ADD KEY `voidordcustomord` (`customer_order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmininfo`
--
ALTER TABLE `tbladmininfo`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblaudittrail`
--
ALTER TABLE `tblaudittrail`
  MODIFY `audittrail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomerinfo`
--
ALTER TABLE `tblcustomerinfo`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomerorders`
--
ALTER TABLE `tblcustomerorders`
  MODIFY `customer_order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomertransactionapp`
--
ALTER TABLE `tblcustomertransactionapp`
  MODIFY `customer_trans_app` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcustomertransactionorder`
--
ALTER TABLE `tblcustomertransactionorder`
  MODIFY `customer_trans_ord_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbldelivermethod`
--
ALTER TABLE `tbldelivermethod`
  MODIFY `deliver_method_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblinventory`
--
ALTER TABLE `tblinventory`
  MODIFY `inventory_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblmaintenanceservice`
--
ALTER TABLE `tblmaintenanceservice`
  MODIFY `Service_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotificationadmin`
--
ALTER TABLE `tblnotificationadmin`
  MODIFY `notification_adm_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotificationappointment`
--
ALTER TABLE `tblnotificationappointment`
  MODIFY `notification_app_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotificationorder`
--
ALTER TABLE `tblnotificationorder`
  MODIFY `notification_ord_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblnotificationtype`
--
ALTER TABLE `tblnotificationtype`
  MODIFY `notification_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblonlinesession`
--
ALTER TABLE `tblonlinesession`
  MODIFY `online_session_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblproductinfo`
--
ALTER TABLE `tblproductinfo`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblproofpayment`
--
ALTER TABLE `tblproofpayment`
  MODIFY `proof_payment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblqrpayment`
--
ALTER TABLE `tblqrpayment`
  MODIFY `qrpayment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblstockin`
--
ALTER TABLE `tblstockin`
  MODIFY `stockin_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsubcategory`
--
ALTER TABLE `tblsubcategory`
  MODIFY `Subategory_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblsupplierinfo`
--
ALTER TABLE `tblsupplierinfo`
  MODIFY `Supplier_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltermsandcondition`
--
ALTER TABLE `tbltermsandcondition`
  MODIFY `Terms_Condition_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltrackorders`
--
ALTER TABLE `tbltrackorders`
  MODIFY `track_order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbltransorderstatus`
--
ALTER TABLE `tbltransorderstatus`
  MODIFY `transorder_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbluseraccount`
--
ALTER TABLE `tbluseraccount`
  MODIFY `User_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblvoidorder`
--
ALTER TABLE `tblvoidorder`
  MODIFY `void_order_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbladmininfo`
--
ALTER TABLE `tbladmininfo`
  ADD CONSTRAINT `useradmin` FOREIGN KEY (`user_id`) REFERENCES `tbluseraccount` (`User_id`);

--
-- Constraints for table `tblaudittrail`
--
ALTER TABLE `tblaudittrail`
  ADD CONSTRAINT `useraudittrail` FOREIGN KEY (`user_id`) REFERENCES `tbluseraccount` (`User_id`);

--
-- Constraints for table `tblcustomerinfo`
--
ALTER TABLE `tblcustomerinfo`
  ADD CONSTRAINT `customerinfouser` FOREIGN KEY (`user_id`) REFERENCES `tbluseraccount` (`User_id`);

--
-- Constraints for table `tblcustomerorders`
--
ALTER TABLE `tblcustomerorders`
  ADD CONSTRAINT `customerordcustomid` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomerinfo` (`customer_id`),
  ADD CONSTRAINT `customerordinventory` FOREIGN KEY (`inventory_id`) REFERENCES `tblinventory` (`inventory_id`),
  ADD CONSTRAINT `customerordrproduct` FOREIGN KEY (`product_id`) REFERENCES `tblproductinfo` (`product_id`);

--
-- Constraints for table `tblcustomertransactionapp`
--
ALTER TABLE `tblcustomertransactionapp`
  ADD CONSTRAINT `customtransappcustom` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomerinfo` (`customer_id`),
  ADD CONSTRAINT `customtransappservice` FOREIGN KEY (`service_id`) REFERENCES `tblmaintenanceservice` (`Service_id`);

--
-- Constraints for table `tblcustomertransactionorder`
--
ALTER TABLE `tblcustomertransactionorder`
  ADD CONSTRAINT `customtransordcustom` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomerinfo` (`customer_id`),
  ADD CONSTRAINT `customtransordcustomord` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`),
  ADD CONSTRAINT `customtransorddelivery` FOREIGN KEY (`delivery_method_id`) REFERENCES `tbldelivermethod` (`deliver_method_id`),
  ADD CONSTRAINT `customtransordproof` FOREIGN KEY (`proof_payment_id`) REFERENCES `tblproofpayment` (`proof_payment_id`),
  ADD CONSTRAINT `customtransordtransordstat` FOREIGN KEY (`transorder_status_id`) REFERENCES `tbltransorderstatus` (`transorder_status_id`);

--
-- Constraints for table `tblexchangeproduct`
--
ALTER TABLE `tblexchangeproduct`
  ADD CONSTRAINT `exchangeprocustomord` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`);

--
-- Constraints for table `tblinventory`
--
ALTER TABLE `tblinventory`
  ADD CONSTRAINT `inventoryproduct` FOREIGN KEY (`product_id`) REFERENCES `tblproductinfo` (`product_id`);

--
-- Constraints for table `tblnotificationadmin`
--
ALTER TABLE `tblnotificationadmin`
  ADD CONSTRAINT `notificationadmtype` FOREIGN KEY (`notification_type_id`) REFERENCES `tblnotificationtype` (`notification_type_id`);

--
-- Constraints for table `tblnotificationappointment`
--
ALTER TABLE `tblnotificationappointment`
  ADD CONSTRAINT `notificationapptype` FOREIGN KEY (`notification_type_id`) REFERENCES `tblnotificationtype` (`notification_type_id`);

--
-- Constraints for table `tblnotificationorder`
--
ALTER TABLE `tblnotificationorder`
  ADD CONSTRAINT `notificationordtype` FOREIGN KEY (`notification_type_id`) REFERENCES `tblnotificationtype` (`notification_type_id`);

--
-- Constraints for table `tblonlinesession`
--
ALTER TABLE `tblonlinesession`
  ADD CONSTRAINT `onlinesesuser` FOREIGN KEY (`user_id`) REFERENCES `tbluseraccount` (`User_id`);

--
-- Constraints for table `tblproductinfo`
--
ALTER TABLE `tblproductinfo`
  ADD CONSTRAINT `productcategory` FOREIGN KEY (`category_id`) REFERENCES `tblcategory` (`category_id`),
  ADD CONSTRAINT `productsubcategory` FOREIGN KEY (`subcategory_id`) REFERENCES `tblsubcategory` (`Subategory_id`),
  ADD CONSTRAINT `productsupplier` FOREIGN KEY (`supplier_id`) REFERENCES `tblsupplierinfo` (`Supplier_id`);

--
-- Constraints for table `tblproductreturn`
--
ALTER TABLE `tblproductreturn`
  ADD CONSTRAINT `productreturncustomord` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`);

--
-- Constraints for table `tblproofpayment`
--
ALTER TABLE `tblproofpayment`
  ADD CONSTRAINT `proofcustom` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomerinfo` (`customer_id`),
  ADD CONSTRAINT `proofcustomorder` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`);

--
-- Constraints for table `tblstockin`
--
ALTER TABLE `tblstockin`
  ADD CONSTRAINT `stockininventory` FOREIGN KEY (`inventory_id`) REFERENCES `tblinventory` (`inventory_id`),
  ADD CONSTRAINT `stockinproduct` FOREIGN KEY (`product_id`) REFERENCES `tblproductinfo` (`product_id`),
  ADD CONSTRAINT `stockinsupplier` FOREIGN KEY (`supplier_id`) REFERENCES `tblsupplierinfo` (`Supplier_id`);

--
-- Constraints for table `tbltrackorders`
--
ALTER TABLE `tbltrackorders`
  ADD CONSTRAINT `trackcustomorder` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`);

--
-- Constraints for table `tblvoidorder`
--
ALTER TABLE `tblvoidorder`
  ADD CONSTRAINT `voidordcustom` FOREIGN KEY (`customer_id`) REFERENCES `tblcustomerinfo` (`customer_id`),
  ADD CONSTRAINT `voidordcustomord` FOREIGN KEY (`customer_order_id`) REFERENCES `tblcustomerorders` (`customer_order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

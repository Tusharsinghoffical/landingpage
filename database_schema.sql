-- Database: packers_movers
-- Table structure for table `inquiries`

CREATE DATABASE IF NOT EXISTS packers_movers;
USE packers_movers;

DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `service` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data for testing
INSERT INTO `inquiries` (`name`, `email`, `mobile`, `service`, `message`) VALUES
('Rajesh Kumar', 'rajesh.kumar@gmail.com', '9876543210', 'House Shifting', 'Looking for house shifting services from Mumbai to Delhi. Need quotation for 2BHK apartment.'),
('Priya Sharma', 'priya.sharma@yahoo.com', '9876543211', 'Office Relocation', 'Need to relocate our office from Bangalore to Hyderabad. Around 50 workstations and IT equipment.'),
('Anil Reddy', 'anil.reddy@hotmail.com', '9876543212', 'Packing Services', 'Require professional packing services for fragile items including electronics and glassware.'),
('Sunita Verma', 'sunita.verma@outlook.com', '9876543213', 'Car Transportation', 'Need to transport my car from Chennai to Pune. Open carrier is fine.'),
('Vikram Singh', 'vikram.singh@gmail.com', '9876543214', 'Storage Services', 'Looking for short-term storage solution for 3 months during home renovation.');

COMMIT;
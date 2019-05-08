
/*Create Tables*/

/* Something is wrong with the animalId in Animals table--it isn't allowing to be used as a foreign key. */
DROP DATABASE IF EXISTS capstone;
CREATE DATABASE capstone;
USE capstone;

/*
Animals AM done
Home_Requirements HR done
Employees EM done
Shelters SH done
Shelter_Animal SA done
Registered_Fosters FO done
Foster_Applicants FO done
Foster_Applications AP done
Foster_Activity FA done
Foster_Preference FP
Animal_Request AR done
Foster_HOME FH
Transaction: add animal
Transaction: add shelter
Transaction: approve foster_application
Transaction: approve animal_request
*/


CREATE TABLE Employees (
  employeeId int NOT NULL,
  title varchar(25),
  grade varchar(10),
  lastName varchar(25),
  firstName varchar(25),
  emailAddress varchar(50),
  userAddress varchar(50),
  userCity varchar(20),
  userState varchar(2),
  userZipCode int(9),
  phone varchar(20),
  birthdate date,
  PRIMARY KEY (employeeId)
);

/* Employees */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/employee_data.csv'
INTO TABLE employees
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update employeeId to autoincrement with new rows */
ALTER TABLE Employees AUTO_INCREMENT = 11050;


CREATE TABLE Animals (
  animalId int NOT NULL,
  animalName varchar(60),
  location char(25),
  age int(3),
  ageStatus char(10),
  microchipId varchar(25),
  species char(10),
  breed1 char(50),
  breed2 char(50),
  sex char(25),
  color1 char(10),
  color2 char(10),
  size char(50),
  sterilized char(10),
  vaccinated char(25),
  houseTrained char(10),
  registrationDate date,
  shelterTenure int(5) DEFAULT 0,
  specialNeeds char(10) DEFAULT 'no',
  goodWithDogs char(10) DEFAULT 'no',
  goodWithCats char(10) DEFAULT 'no',
  goodWithOther char(10) DEFAULT 'no',
  goodWithChildren char(10) DEFAULT 'no',
  fosterStatus char(50) DEFAULT 'Available to foster',
  shelterId int(11),
  description text(500),
  PRIMARY KEY (animalId)
);

/* Animals */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/animal_data2.csv'
INTO TABLE Animals
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update animalId to autoincrement with new rows */
ALTER TABLE Animals MODIFY animalId int(11) auto_increment;
ALTER TABLE Animals AUTO_INCREMENT = 31800;

/* Update registrationDate to timestamp */
ALTER TABLE Animals MODIFY registrationDate TIMESTAMP;

/* Add Default value for animal location */
ALTER TABLE Animals MODIFY location char(25) DEFAULT 'shelter';

/* Remove 0 from shelterId */
UPDATE Animals SET shelterId = NULL
WHERE shelterId = 0;

/* Add shelter foreign key constraint */
ALTER TABLE Animals
ADD FOREIGN KEY (shelterId) REFERENCES Shelters(shelterId);

/* Remove update for current_timestamp */
ALTER TABLE Animals
CHANGE registrationDate registrationDate TIMESTAMP NOT NULL default CURRENT_TIMESTAMP;

/* Create calculated column */
/*ALTER TABLE Animals
ADD COLUMN daysWithRescue int(5) AS (DATEDIFF("2019-05-01",Animals.registrationDate));
*/

CREATE TABLE Shelters (
  shelterId int NOT NULL,
  shelterName char(50),
  shelterAddress varchar(50),
  shelterCity char(50),
  shelterState char(10),
  shelterZip int(10),
  shelterPhoneNumber varchar(50),
  euthStatus char(50),
  euthDuration varchar(45),
  PRIMARY KEY (shelterId)
);

/* Shelters */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/shelters_data.csv'
INTO TABLE shelters
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update shelterId to autoincrement with new rows */
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Shelters MODIFY COLUMN shelterId int(11) auto_increment;
ALTER TABLE Shelter AUTO_INCREMENT = 91025;
SET FOREIGN_KEY_CHECKS=1;



CREATE TABLE Home_Requirements (
  homeReqId int NOT NULL,
  homeType char(20),
  fencedBackyard char(10),
  homePrefWithMen char(10),
  homePrefWithWomen char(10),
  homePrefWithChildren char(10),
  homePrefWithPets char(10),
  animalId int,
  PRIMARY KEY (homeReqId),
  FOREIGN KEY (animalId) REFERENCES animals(animalId)
);

/* Home_Requirements */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/homereq_data2.csv'
INTO TABLE home_requirements
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update homeReqId to autoincrement with new rows */
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Home_Requirements MODIFY COLUMN homeReqId int(11) auto_increment;
ALTER TABLE Home_Requirements AUTO_INCREMENT = 101853;
SET FOREIGN_KEY_CHECKS=1;


CREATE TABLE Shelter_Animal (
  shelterAnimalId int NOT NULL,
  species char(10),
  shelterId int,
  arrivalDate date,
  euthDate date,
  daysToEuth int(2),
  PRIMARY KEY (shelterAnimalId),
  FOREIGN KEY (shelterId) REFERENCES Shelters(shelterId)
);

/* Shelter_Animal */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/shelter_animals_data.csv'
INTO TABLE shelter_animal
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update homeReqId to autoincrement with new rows */
ALTER TABLE Shelter_Animal AUTO_INCREMENT = 111249;


CREATE TABLE Registered_Fosters (
  fosterId int NOT NULL,
  lastName varchar(25),
  firstName varchar(25),
  emailAddress varchar(25),
  gender char(10),
  userAddress varchar(50),
  userCity varchar(20),
  userState varchar(20),
  userZipCode int(9),
  phone varchar(20),
  birthDate date,
  employmentStatus varchar(20),
  fosterActivity varchar(25), /* Defines if they are fostering or not--Active Foster or Inactive Foster*/
  specialNeedsExp char(10),
  hoursAway int(2),
  applicationId int,
  PRIMARY KEY (fosterId)
);

/* Registered_Fosters */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/registered_fosters.csv'
INTO TABLE Registered_Fosters
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Fix some email addresses */
UPDATE Registered_Fosters SET emailAddress = 'VillalobosL@aol.com' WHERE fosterId = 51008;
UPDATE Registered_Fosters SET emailAddress = 'GalvanB@aol.com' WHERE fosterId = 51187;

/* Add Default to fosterActivity */
ALTER TABLE Registered_Fosters MODIFY fosterActivity varchar(25) DEFAULT 'Inactive Foster';


CREATE TABLE Foster_Applicants (
  fosterId int NOT NULL,
  lastName varchar(25),
  firstName varchar(25),
  emailAddress varchar(50),
  gender char(10),
  userAddress varchar(50),
  userCity varchar(20),
  userState char(10),
  userZipCode int(9),
  phone varchar(20),
  birthdate date,
  employmentStatus varchar(20),
  specialNeedsExp char(10),
  hoursAway int(2),
  applicationId int,
  PRIMARY KEY (fosterId)
);

/* Foster_Applicants */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/foster_applicants.csv'
INTO TABLE Foster_Applicants
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update Foster_Applicants to autoincrement with new rows */
ALTER TABLE Foster_Applicants MODIFY fosterId int auto_increment;
ALTER TABLE Foster_Applicants AUTO_INCREMENT = 51500;

CREATE TABLE Foster_Applications (
  applicationId int NOT NULL,
  status char(25),
  submissionDate date,
  fosterId int,
  applicantId int,
  PRIMARY KEY (applicationId),
  FOREIGN KEY (applicantId) REFERENCES Foster_Applicants(fosterId)
);

/* Foster_Applications */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/applications_data.csv'
INTO TABLE Foster_Applications
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Add applicant's fosterIds to the applicantId column*/
UPDATE Foster_Applications
SET applicantId = fosterId
WHERE fosterId > 51349;

/* Remove applicant's fosterIds from the fosterId column */
UPDATE Foster_Applications
set fosterId = NULL
Where fosterId > 51349;

/* Add in the foreign key constraint between Registered_Fosters and Foster_applications*/
ALTER TABLE Foster_Applications
ADD FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId);

SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Foster_Applications MODIFY COLUMN applicationId int(11) auto_increment;
ALTER TABLE Foster_Applications AUTO_INCREMENT = 61500;
SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE Foster_Applicants
ADD FOREIGN KEY (applicationId) REFERENCES Foster_Applications(applicationId);

/* Update submissionDate to timestamp */
ALTER TABLE Foster_Applications MODIFY submissionDate TIMESTAMP;
ALTER TABLE Foster_applications MODIFY status char(25) DEFAULT 'Submitted';


CREATE TABLE Foster_Activity (
  activityId int NOT NULL,
  type char(25),
  approvalDate date,
  duration varchar(3),
  status char(25),
  fosterId int,
  animalId int,
  PRIMARY KEY (activityId),
  FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId)
);

/* Foster_Activity */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/activity_data.csv'
INTO TABLE Foster_Activity
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

ALTER TABLE Foster_Activity AUTO_INCREMENT = 121297;


CREATE TABLE Animal_Request (
  requestId int NOT NULL,
  requestDate date,
  fosterId int,
  animalId int,
  requestStatus char(50),
  PRIMARY KEY (requestId),
  FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId),
  FOREIGN Key (animalId) REFERENCES Animals(animalId)
);

/* Animal_Request */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/animalrequest_data.csv'
INTO TABLE Animal_Request
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update requestId to autoincrement with new rows */
ALTER TABLE Animal_Request MODIFY requestId int(11) auto_increment;
ALTER TABLE Animal_Request AUTO_INCREMENT = 41301;

/* Set timestamp */
ALTER TABLE Animal_Request MODIFY requestDate TIMESTAMP;
ALTER TABLE Animal_Request CHANGE requestDate requestDate TIMESTAMP NOT NULL default CURRENT_TIMESTAMP;
ALTER TABLE Animal_Request MODIFY requestStatus varchar(50) DEFAULT 'Submitted';

CREATE TABLE Foster_Home (
  homeId int NOT NULL,
  homeType char(20),
  fencedBackyard char(10),
  homeOwnership char(10),
  residents int(2),
  pets char(10),
  petsVaccinated char(25),
  fosterId int,
  PRIMARY KEY (homeId)
);

/* Foster_Preference */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/fosterhomes_data.csv'
INTO TABLE Foster_Home
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

ALTER TABLE Foster_Home
ADD COLUMN applicantId int
AFTER fosterId;

/* Add applicant's fosterIds to the applicantId column*/
UPDATE Foster_Home
SET applicantId = fosterId
WHERE fosterId > 51349;

/* Remove applicant's fosterIds from the fosterId column */
UPDATE Foster_Home
set fosterId = NULL
Where fosterId > 51349;


/* Add in the foreign key constraints between
   Foster_Home and Registered_Fosters and Foster_Applicants*/
ALTER TABLE Foster_Home
ADD FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId);

ALTER TABLE Foster_Home
ADD FOREIGN KEY (applicantId) REFERENCES Foster_Applicants(fosterId);

/* Update homeId to autoincrement with new rows */
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Foster_Home MODIFY COLUMN homeId int(11) auto_increment;
ALTER TABLE Foster_Home AUTO_INCREMENT = 71350;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE Foster_Preference (
  preferenceId int NOT NULL,
  shelter1 varchar(45),
  shelter2 varchar(45),
  species char(20),
  size char(20),
  age char(10),
  specialNeeds char(10),
  fosterToAdopt char(10),
  availableNow char(10),
  animalCount int(2) DEFAULT 0,
  fosterId int,
  PRIMARY KEY (preferenceId)
);

/* Foster_Preference */
LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/fosterpref_data.csv'
INTO TABLE Foster_Preference
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

ALTER TABLE Foster_Preference
ADD COLUMN applicantId int
AFTER fosterId;

/* Add applicant's fosterIds to the applicantId column*/
UPDATE Foster_Preference
SET applicantId = fosterId
WHERE fosterId > 51349;

/* Remove applicant's fosterIds from the fosterId column */
UPDATE Foster_Preference
set fosterId = NULL
Where fosterId > 51349;

/* Add in the foreign key constraints between
   Foster_Home and Registered_Fosters and Foster_Applicants*/
ALTER TABLE Foster_Preference
ADD FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId);

ALTER TABLE Foster_Preference
ADD FOREIGN KEY (applicantId) REFERENCES Foster_Applicants(fosterId);

/* Update preferenceId to autoincrement with new rows */
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Foster_Preference MODIFY COLUMN preferenceId int(11) auto_increment;
ALTER TABLE Foster_Preference AUTO_INCREMENT = 81350;
SET FOREIGN_KEY_CHECKS=1;


/* Administrator_Accounts */
CREATE TABLE Administrator_Accounts (
  adminId int NOT NULL,
  employeeId int NOT NULL,
  adminPasswordHash binary(64),
  permissionsLevel int,
  PRIMARY KEY (adminId),
  FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/admin_accounts.csv'
INTO TABLE Administrator_Accounts
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update preferenceId to autoincrement with new rows */
ALTER TABLE Administrator_Accounts AUTO_INCREMENT = 21008;

/* Foster_Accounts */
CREATE TABLE Foster_Accounts (
  accountId varchar(50) NOT NULL,
  fosterPasswordHash binary(64),
  fosterId int,
  applicantId int,
  PRIMARY KEY (accountId),
  FOREIGN KEY (fosterId) REFERENCES Registered_Fosters(fosterId),
  FOREIGN KEY (applicantId) REFERENCES Foster_Applicants(fosterId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/foster_accounts.csv'
INTO TABLE Foster_Accounts
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

UPDATE Foster_Accounts
SET applicantId = NULL
WHERE applicantId = 0;

UPDATE Foster_Accounts
SET fosterId = NULL
WHERE fosterId = 0;

/* Shelter Transaction */
CREATE TABLE Shelter_Trans (
  shelterTransId INT NOT NULL,
  transType VARCHAR(45),
  transDate DATETIME,
  employeeId INT,
  shelterId INT,
  PRIMARY KEY (shelterTransId),
  FOREIGN KEY (employeeId) REFERENCES Employees(employeeId),
  FOREIGN KEY (shelterId) REFERENCES Shelters(shelterId)
);

ALTER TABLE Shelter_Trans AUTO_INCREMENT = 49;

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/shelterTrans_data.csv'
INTO TABLE Shelter_Trans
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;


/* Foster Application Decisions */
CREATE TABLE Foster_App_Decisions (
  appDecisionId INT NOT NULL,
  applicationId INT NOT NULL,
  employeeId INT NOT NULL,
  fosterAppDecision VARCHAR(45),
  reasonCode VARCHAR(45),
  transDate DATETIME,
  PRIMARY KEY (appDecisionId),
  FOREIGN KEY (applicationId) REFERENCES Foster_Applications(applicationId),
  FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/appDec_data.csv'
INTO TABLE Foster_App_Decisions
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update appDecisionId to autoincrement with new rows */
SET FOREIGN_KEY_CHECKS=0;
ALTER TABLE Foster_App_Decisions MODIFY COLUMN appDecisionId int(11) auto_increment;
ALTER TABLE Foster_App_Decisions AUTO_INCREMENT = 371;
SET FOREIGN_KEY_CHECKS=1;

/* Set timestamp */
ALTER TABLE Foster_App_Decisions MODIFY transDate TIMESTAMP;
ALTER TABLE Foster_App_Decisions CHANGE transDate transDate TIMESTAMP NOT NULL default CURRENT_TIMESTAMP;

/* Animal Request Decision */
CREATE TABLE Request_Decisions (
  requestDecId INT NOT NULL,
  employeeId INT NOT NULL,
  requestId INT NOT NULL,
  decision VARCHAR(45),
  reasonCode VARCHAR(45),
  transDate DATETIME,
  PRIMARY KEY (requestDecId),
  FOREIGN KEY (employeeId) REFERENCES Employees(employeeId),
  FOREIGN KEY (requestId) REFERENCES Animal_Request(requestId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/reqDec_data.csv'
INTO TABLE Request_Decisions
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Update animalId to autoincrement with new rows */
ALTER TABLE Request_Decisions MODIFY requestDecId int(11) auto_increment;
ALTER TABLE Request_Decisions AUTO_INCREMENT = 214;

/* Employee Account */
CREATE TABLE Employee_Account (
  employeeAcctId VARCHAR(45) NOT NULL,
  accountPasswordHash BINARY(64) NOT NULL,
  employeeId INT NOT NULL,
  PRIMARY KEY (employeeAcctId),
  FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/employee_accounts.csv'
INTO TABLE Employee_Account
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

/* Photos */
CREATE TABLE Animal_Photos (
  photoId int(11) NOT NULL AUTO_INCREMENT,
  photoPath varchar(255),
  animalId int(11) NOT NULL,
  PRIMARY KEY (photoId),
  FOREIGN KEY (animalId) REFERENCES Animals(animalId)
);

LOAD DATA INFILE '/opt/bitnami/apache2/htdocs/Data/Test/animal_photos.csv'
INTO TABLE Animal_Photos
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

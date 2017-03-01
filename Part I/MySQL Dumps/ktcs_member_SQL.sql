CREATE TABLE ktcs_member (
  MemberID int(11) NOT NULL,
  NameFirst varchar(40) NOT NULL,
  NameLast varchar(40) NOT NULL,
  AddressLine varchar(40) NOT NULL,
  PostalCode varchar(20) NOT NULL,
  Province varchar(30) NOT NULL,
  City varchar(40) NOT NULL,
  Country varchar(40) NOT NULL,
  PhoneNumber varchar(10) NOT NULL,
  Email varchar(100) NOT NULL,
  DriverLicense varchar(100) NOT NULL,
  MembershipFee decimal(10,2) NOT NULL,
  Password varchar(20) NOT NULL,
  Credit_Card varchar(20) NOT NULL,
  primary key (MemberID));
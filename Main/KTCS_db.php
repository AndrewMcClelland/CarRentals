<html>
<head><title>Load KTCS Database</title></head>
<body>

<?php

	$host = "localhost";
 	$user = "root";
 	$password = "";
 	$database = "KTCS";

 	$cxn = mysqli_connect($host,$user,$password, $database);

  	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
  	}

	echo "DROPPING TABLES...";
	echo "<br>";

  	mysqli_query($cxn,"drop table Parking_Location;");
  	mysqli_query($cxn,"drop table Car;");
  	mysqli_query($cxn,"drop table Car_Rental_History;");
  	mysqli_query($cxn,"drop table Car_Maintenance_History;");
  	mysqli_query($cxn,"drop table Rental_Comment;");
  	mysqli_query($cxn,"drop table Reservations;");
	mysqli_query($cxn,"drop table KTCS_Member;");
	mysqli_query($cxn,"drop table Payment_History;");
	mysqli_query($cxn,"drop table Admin;");
  	echo "* tables dropped *<br>";

  	echo "<br>";
	echo "<br>";
	echo "CREATING TABLES...";
	echo "<br>";

  	// CREATING TABLES

  	mysqli_query($cxn,"create table Parking_Location
	(
		LocationID int NOT NULL,
		AddressLine varchar(40) NOT NULL,
		PostalCode varchar(20) NOT NULL,
		Province varchar(30) NOT NULL,
		City varchar(40) NOT NULL,
		Country varchar(40) NOT NULL,
	 	Spaces integer NOT NULL,
	 	primary key (LocationID)
	);");
	echo "* Parking_Locations created *<br>";


	mysqli_query($cxn,"create table Car
	(
		VIN int NOT NULL,
		Make varchar(15) NOT NULL,
		Model varchar(15) NOT NULL,
		Year int NOT NULL,
		LocationID int NOT NULL,
		Colour varchar(10) NOT NULL,
		PictureLink varchar(50) NOT NULL,
		RentalFee numeric(10,2) NOT NULL,
		primary key (VIN),
		foreign key (LocationID) references Parking_Location(LocationID)
	);");
	echo "* Car created *<br>";


	mysqli_query($cxn,"create table Car_Rental_History
	(
		VIN int NOT NULL,
		MemberID int NOT NULL,
		PickupOdometer int NOT NULL,
		DropoffOdometer int NOT NULL,
    PickupStatus varchar (11) NOT NULL CHECK (Status = 'normal' OR Status = 'damaged' OR Status = 'not running'),
    DropoffStatus varchar (11) NOT NULL CHECK (Status = 'normal' OR Status = 'damaged' OR Status = 'not running'),
    PickupDate DATETIME NOT NULL,
    DropoffDate DATETIME NOT NULL,
    primary key (VIN, MemberID, PickupOdometer, DropoffOdometer, PickupStatus, DropoffStatus, PickupDate, DropoffDate)
  );");
	echo "* Car_Rental_History created *<br>";


	mysqli_query($cxn,"create table Car_Maintenance_History
	(
		VIN int NOT NULL,
		Date date NOT NULL,
		Odometer int NOT NULL,
		Maintenance varchar(9) NOT NULL CHECK (Maintenance = 'scheduled' OR Maintenance = 'repair' OR Maintenance = 'body work'),
		Description varchar(80) NOT NULL,
		primary key (VIN, Date, Odometer, Maintenance, Description)
	);");
	echo "* Car_Maintenance_History created *<br>";

	mysqli_query($cxn,"create table Rental_Comment
	(
		VIN int NOT NULL,
		MemberID int NOT NULL,
		Rating int NOT NULL CHECK (Rating > 0 AND Rating < 5),
		Comment varchar(500),
		Date date NOT NULL,
		ReplyComment varchar(500),
		ReplyDate date,
		primary key (VIN, MemberID, Rating, Comment, Date, ReplyComment, ReplyDate)
	);");
	echo "* Rental_Comments created *<br>";

	mysqli_query($cxn,"create table KTCS_Member
	(
		MemberID int NOT NULL,
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
		MembershipFee numeric(10,2) NOT NULL,
		Password varchar(100) NOT NULL,
		Credit_Card varchar(20) NOT NULL,
		primary key (MemberID)
	);");
	echo "* Member created *<br>";

		mysqli_query($cxn,"create table Reservations
	(
		ReservationID int NOT NULL,
		MemberID int NOT NULL,
		VIN int NOT NULL,
		StartDate date NOT NULL,
		EndDate date NOT NULL,
		AccessCode int NOT NULL,
		primary key (ReservationID),
		foreign key (VIN) references Car (VIN),
		foreign key (MemberID) references KTCS_Member (MemberID)
	);");
	echo "* Reservation created *<br>";

	mysqli_query($cxn,"create table Payment_History
	(
		MemberID int NOT NULL,
		Amount numeric(10,2) NOT NULL,
		Date date NOT NULL,
		Description varchar(100) NOT NULL,
		primary key (MemberID, Amount, Date, Description)
	);");
	echo "* Payment_History created *<br>";

	mysqli_query($cxn,"create table Admin
	(
		AdminCode int NOT NULL,
		Email varchar(100) NOT NULL,
		Password varchar(60) NOT NULL,
		primary key (AdminCode)
	);");
	echo "* Admin created *<br>";

	echo "<br>";
	echo "<br>";
	echo "INSERTING VALUES INTO TABLES...";
	echo "<br>";
	//INSERT VALUES INTO TABLES

	mysqli_query($cxn, "insert into Parking_Location values
		('86', '230 Johnson Lane', 'K1Z 9U7', 'Ontario', 'Kingston', 'Canada', '25'),
		('24', '88 Union Street', 'K1Z 9U7', 'Ontario', 'Kingston', 'Canada', '55'),
		('92', '69 Database Lane', 'K1Z 8L0', 'Ontario', 'Toronto', 'Canada', '40')
	;");
	echo "* Parking_Location values inserted *<br>";

	mysqli_query($cxn, "insert into Car values
		('20140294', 'Toyota', 'Corolla', '2014', '86', 'Green', 'welovetoyota.com/2018', '30.2'),
		('20140295', 'Porsche', 'Cayenne', '2014', '24', 'Blue', 'porsche.com/2017', '42.4'),
		('20140296', 'Tesla', 'Model 3', '2017', '92', 'Red', 'tesla.com/model3', '20.00'),
		('20140297', 'Subaru', 'Outback', '2018', '86', 'Silver', 'subaru.com/outback', '34.00')
	;");
	echo "* Car values inserted *<br>";

  mysqli_query($cxn, "insert into Car_Rental_History values
      ('20140294', '20', '124234', '3211231', 'normal', 'normal', '2017-03-16 10:00:00', '2017-03-29 18:00:00'),
      ('20140295', '24', '234134', '3211231', 'normal', 'damaged', '2017-03-12 10:00:00', '2017-03-29 16:00:00'),
      ('20140296', '32', '12321', '20000', 'normal', 'not running', '2017-02-12 10:00:00', '2017-02-15 18:00:00')
      ;");
      echo "* Car_Rental_History values inserted *<br>";

	mysqli_query($cxn, "insert into Car_Maintenance_History values
		('20140294', '1998-07-04', '84000', 'Scheduled', 'Scheduled mainenance for oil check.'),
		('20140295', '2014-02-18', '68000', 'Repair', 'Repair the front bumper.'),
		('20140296', '2012-12-20', '9000', 'Body Work', 'Putting on cool racing stripes.')
	;");
	echo "* Car_Maintenance_History values inserted *<br>";

	mysqli_query($cxn, "insert into Rental_Comment values
		('20140294', '20', '1', 'Terrible car goes way to fast', '2015-01-02', NULL, NULL),
		('20140295', '24', '1', 'Terrible car goes way to slow', '2014-05-28', 'You should change gears then...', '2015-02-03'),
		('20140296', '32', '4', 'Great car goes way to fast', '2016-05-03', NULL, NULL)
	;");
	echo "* Rental_Comment values inserted *<br>";

	mysqli_query($cxn, "insert into KTCS_Member values
		('20', 'Andrew', 'Hello', '10 Hello Lane', 'K7L1V2', 'Ontario', 'Kingston', 'Canada', '6471111111', 'hello@hello.com', 'B2746-1026-336-3048', '30', 'ilikedogs', '5301063177596486'),
		('24', 'Ryan', 'Freddy', '10 Goodbye Lane', 'K7L8F3', 'Ontario', 'Kingston', 'Canada', '6472345678', 'bye@bye.com', 'C9384-1026-232-3048', '30', 'ilikecats', '5231094377093486'),
		('32', 'Rony', 'Bes', '10 Database Lane', 'K7H8Z3', 'Ontario', 'Toronto', 'Canada', '6478439900', 'dbms@dbms.com', 'F9020-3231-333-9809', '30', 'ilikebirds', '5237483277093486'),
    (33, 'Test', 'User', '1 Test Lane', 'K6AB26', 'Ontario', 'Toronto', 'Canada', '6471111234', 'testuser@gmail.com', 'D24185019184726', '30.00', '$2y$10$.D2kjEoSRf0phSKUsv.N6O5bhbXPHl6lZuTgQluwfgkc82/L34BEq', '2719308161782')
	;");
	echo "* KTCS_Member values inserted *<br>";

	mysqli_query($cxn, "insert into Reservations values
		('26', '20', '20140294', '1998-07-04', '2000-12-08', '7897823'),
		('82', '24', '20140295', '2014-02-18', '2016-04-02', '424342'),
		('44', '32', '20140296', '2012-12-20', '2012-12-22', '7897823')
	;");
	echo "* Reservation values inserted *<br>";

	mysqli_query($cxn, "insert into Payment_History values
		('20', '344.10', '2014-06-07', 'You rented the Tesla Model 3.'),
		('24', '30.00', '2012-01-31', 'Youre monthly payment fee.'),
		('32', '1000.00', '1996-04-07', 'You rented the Bugatti Veyron.')
	;");
	echo "* Payment_History values inserted *<br>";

	mysqli_query($cxn, "insert into Admin values
		('23121', 'hello@gmail.com', 'helloworld'),
		('42342', 'bye@gmail.com', 'byeworld'),
		('42421', 'hello@bye.com', 'hellobyeworld')
	;");
	echo "* Admin values inserted *<br>";

	echo "<br>";

	mysqli_close($cxn);

?>
</body></html>

<html>
<head><title>Load KTCS Database</title></head>
<body>

<?php

	$host = "localhost";
 	$user = "root";
 	$password = "";
 	$database = "KTCS";

 	$cxn = mysqli_connect($host,$user,$password, $database);
	$quant = mysqli_connect($host,$user,$password);
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
		ReservationID varchar(20) NOT NULL,
		MemberID int NOT NULL,
		VIN int NOT NULL,
		StartDate date NOT NULL,
		EndDate date NOT NULL,
		AccessCode varchar(20) NOT NULL,
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
		('20140201', 'Jeep', 'GC', '2014', '24', 'Blue', 'jeep.com/grandcherokee', '20.4'),
		('20140202', 'Jeep', 'Compass', '2015', '24', 'Green', 'jeep.com/compass', '40.4'),
		('20140203', 'Jeep', 'Compass', '2015', '24', 'Green', 'jeep.com/compass', '40.4'),
		('20140204', 'Jeep', 'Wrangler', '2016', '24', 'White', 'jeep.com/wrangler', '60.4'),
		('20140205', 'Jeep', 'Patriot', '2017', '24', 'Yellow', 'jeep.com/patriot', '80.4'),
		('20140206', 'Jeep', 'CJ', '2014', '24', 'Black', 'jeep.com/cj', '90.4'),
		('20140207', 'Audi', 'A3', '2017', '92', 'Red', 'audi.com/a3', '200.00'),
		('20140208', 'Audi', 'A4', '2017', '92', 'Green', 'audi.com/a4', '300.00'),
		('20140209', 'Audi', 'A5', '2017', '92', 'Gold', 'audi.com/a5', '400.00'),
		('20140210', 'Audi', 'Q5', '2017', '92', 'White', 'audi.com/q5', '500.00'),
		('20140211', 'Audi', 'Q7', '2017', '92', 'Blue', 'audi.com/q7', '600.00'),
		('20140212', 'Subaru', 'Outback', '2018', '86', 'Silver', 'subaru.com/outback', '48.00'),
		('20140213', 'Subaru', 'Crosstrek', '2018', '86', 'Gold', 'subaru.com/crosstrek', '62.00'),
		('20140214', 'Subaru', 'WRX', '2014', '86', 'Green', 'subaru.com/wrx', '86.2'),
		('20140215', 'Subaru', 'Legacy', '2014', '86', 'White', 'subaru.com/legacy', '92.2'),
		('20140216', 'Subaru', 'Forester', '2014', '86', 'Black', 'subaru.com/forester', '100.2')
		;");
	echo "* Car values inserted *<br>";

  mysqli_query($cxn, "insert into Car_Rental_History values
      ('20140212', '20', '124234', '3211231', 'normal', 'normal', '2017-03-16 10:00:00', '2017-03-29 18:00:00'),
			('20140212', '24', '1002', '2001', 'normal', 'damaged', '2012-03-16 10:00:00', '2012-03-30 18:00:00'),
			('20140212', '32', '213', '3213', 'normal', 'not running', '2013-04-01 10:00:00', '2013-04-10 18:00:00'),
			('20140213', '20', '4432', '4500', 'normal', 'normal', '2016-03-16 10:00:00', '2016-03-29 18:00:00'),
			('20140213', '24', '400', '800', 'normal', 'normal', '2015-03-16 10:00:00', '2015-03-30 18:00:00'),
			('20140213', '32', '423', '4234', 'normal', 'not running', '2010-04-01 10:00:00', '2010-04-10 18:00:00'),
			('20140214', '20', '4234', '42343', 'normal', 'not running', '2017-05-16 10:00:00', '2017-05-29 18:00:00'),
			('20140214', '24', '42342', '323133', 'normal', 'normal', '2012-04-16 10:00:00', '2012-04-30 18:00:00'),
			('20140214', '32', '100', '150', 'normal', 'not running', '2013-02-01 10:00:00', '2013-02-10 18:00:00'),
			('20140215', '20', '200', '300', 'normal', 'normal', '2016-03-16 10:00:00', '2016-03-29 18:00:00'),
			('20140215', '24', '400', '500', 'normal', 'normal', '2012-08-16 10:00:00', '2012-08-30 18:00:00'),
			('20140215', '32', '32332', '323232', 'normal', 'normal', '2013-11-01 10:00:00', '2013-11-10 18:00:00'),
			('20140216', '20', '800', '1000', 'normal', 'normal', '2017-03-16 10:00:00', '2017-03-29 18:00:00'),
			('20140216', '24', '2500', '3000', 'normal', 'damaged', '2012-03-16 10:00:00', '2012-03-30 18:00:00'),
			('20140216', '32', '4000', '8000', 'normal', 'not running', '2013-04-01 10:00:00', '2013-04-10 18:00:00')
      ;");
      echo "* Car_Rental_History values inserted *<br>";

	mysqli_query($cxn, "insert into Car_Maintenance_History values
		('20140212', '2012-05-30', '2002', 'Repair', 'Fixed up the problem.'),
		('20140213', '2015-04-01', '4235', 'Repair', 'Fixed up the transmission.'),
		('20140214', '2016-02-18', '151', 'Repair', 'Repair the front bumper.'),
		('20140216', '2012-05-20', '3001', 'Body Work', 'Putting on cool racing stripes.')
	;");
	echo "* Car_Maintenance_History values inserted *<br>";

	mysqli_query($cxn, "insert into Rental_Comment values
		('20140212', '20', '1', 'Terrible car goes way to fast', '2015-01-02', NULL, NULL),
		('20140213', '24', '1', 'Terrible car goes way to slow', '2014-05-28', 'You should change gears then...', '2015-02-03'),
		('20140214', '32', '4', 'Great car goes way to fast', '2016-05-03', NULL, NULL)
	;");
	echo "* Rental_Comment values inserted *<br>";

	mysqli_query($cxn, "insert into KTCS_Member values
		('20', 'Andrew', 'Hello', '10 Hello Lane', 'K7L1V2', 'Ontario', 'Kingston', 'Canada', '6471111111', 'hello@hello.com', 'B2746-1026-336-3048', '30', 'ilikedogs', '5301063177596486'),
		('24', 'Ryan', 'Freddy', '10 Goodbye Lane', 'K7L8F3', 'Ontario', 'Kingston', 'Canada', '6472345678', 'bye@bye.com', 'C9384-1026-232-3048', '30', 'ilikecats', '5231094377093486'),
		('33', 'Rony', 'Bes', '10 Database Lane', 'K7H8Z3', 'Ontario', 'Toronto', 'Canada', '6478439900', 'dbms@dbms.com', 'F9020-3231-333-9809', '30', 'ilikebirds', '5237483277093486'),
    (32, 'Test', 'User', '1 Test Lane', 'K6AB26', 'Ontario', 'Toronto', 'Canada', '6471111234', 'testuser@gmail.com', 'D24185019184726', '30.00', '$2y$10$.D2kjEoSRf0phSKUsv.N6O5bhbXPHl6lZuTgQluwfgkc82/L34BEq', '2719308161782')
	;");
	echo "* KTCS_Member values inserted *<br>";

	mysqli_query($cxn, "insert into Reservations values
		('26', '20', '20140212', '2018-07-04', '2019-12-08', '7897823'),
		('82', '24', '20140213', '2018-02-18', '2019-04-02', '424342'),
		('44', '32', '20140214', '2018-12-20', '2019-12-22', '7897823')
	;");
	echo "* Reservation values inserted *<br>";

	mysqli_query($cxn, "insert into Payment_History values
		('20', '344.10', '2014-06-07', 'You rented the Tesla Model 3.'),
		('24', '30.00', '2012-01-01', 'Youre monthly payment fee.'),
		('32', '30.00', '2017-02-01', 'Youre monthly payment fee.'),
		('32', '30.00', '2017-03-01', 'Youre monthly payment fee.'),
		('32', '30.00', '2017-04-01', 'Youre monthly payment fee.'),
		('32', '1000.00', '2017-02-04', 'You rented the Bugatti Veyron.')
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

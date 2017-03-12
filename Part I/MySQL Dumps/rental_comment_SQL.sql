CREATE TABLE rental_comment (
  VIN int(11) NOT NULL,
  MemberID int(11) NOT NULL,
  Rating int(11) NOT NULL,
  Comment varchar(500) NOT NULL,
  Date date NOT NULL,
  ReplyComment varchar(500) NOT NULL,
  ReplyDate date NOT NULL,
  primary key (VIN, MemberID, Rating, Comment, Date, ReplyComment, ReplyDate));
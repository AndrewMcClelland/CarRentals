CREATE TABLE payment_history (
  MemberID int(11) NOT NULL,
  Amount decimal(10,2) NOT NULL,
  Date date NOT NULL,
  Description varchar(100) NOT NULL,
  primary key (MemberID, Amount, Date, Description));
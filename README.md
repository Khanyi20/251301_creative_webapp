# 251301_creative_webapp

## Video link
https://drive.google.com/file/d/1G0K_6oUwgUBJnPz1ZClN48a1gmflzK4I/view 

## Trade Or Drop

## Project Description


## Features

- User registration
- User login and logout
- Password hashing
- User profiles
- Add items to the marketplace
- Upload item images
- Browse marketplace items
- View individual item details
- Send trade requests
- View incoming trade requests
- View outgoing trade requests
- Accept or reject trade requests
- Responsive design for desktop, tablet and mobile devices

## Database

The application uses MySql to store:
- User accounts
- Marketplace items
- Trade Requests



--> <div align="center"> <!-- Copy your logo into docs/images/logo.png --> <img src="docs/images/logo.png" alt="Trade Or Drop logo" width="140" />


<!-- Optional: add a wide banner/hero screenshot --> <img src="docs/images/hero.png" alt="Trade Or Drop home screen" width="85%" /> </div>
Table of Contents
About the Project
Getting Started
Features
Development Process
Final Outcome
Conclusion
About the Project

Trade Or Drop is a student-to-student marketplace where students swap random, quirky and unwanted items instead of buying new ones. Users register, list an item with a photo, browse what others have posted and send trade requests. Owners then accept or reject each request, and accepted items are marked as traded.

It is a PHP web application with a MySQL database, run locally on XAMPP, with a responsive layout for desktop, tablet and mobile. The project focuses on secure authentication, careful database design with PDO prepared statements, and a clear trade workflow from request to completion.

Built With

Frontend	HTML, CSS (custom, responsive), JavaScript
Backend	PHP (PDO, sessions)
Database	MySQL (managed with phpMyAdmin)
Local server	XAMPP (Apache + MySQL)
Design	Figma
Version control	Git and GitHub

This project keeps the frontend (HTML/CSS/JS) and backend (PHP + MySQL) in one repository, so there is only one repo to set up.

1. Clone the project into XAMPP's htdocs folder

bash
cd C:/xampp/htdocs
git clone https://github.com/Khanyi20/251301_creative_webapp.git

2. Start the servers

Open the XAMPP Control Panel and start Apache and MySQL.

3. Create the database (backend setup)

Go to http://localhost/phpmyadmin
Click New and create a database named creative_app (collation utf8mb4_general_ci)
Open the SQL tab and run the script below (also saved as database/schema.sql):
sql
CREATE TABLE users (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  username   VARCHAR(50)  NOT NULL UNIQUE,
  email      VARCHAR(100) NOT NULL UNIQUE,
  password   VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  user_id        INT NOT NULL,
  item_name      VARCHAR(100) NOT NULL,
  description    TEXT NOT NULL,
  category       VARCHAR(50)  NOT NULL,
  item_condition VARCHAR(50)  NOT NULL,
  image_path     VARCHAR(255) DEFAULT NULL,
  status         ENUM('available','traded') NOT NULL DEFAULT 'available',
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE trade_requests (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  requester_id INT NOT NULL,
  item_id      INT NOT NULL,
  status       ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (item_id)      REFERENCES items(id) ON DELETE CASCADE
);

4. Check the database connection

Open database/db.php. The defaults match a standard XAMPP install:

php
$host   = "localhost";
$dbname = "creative_app";
$dbuser = "root";
$dbpass = "";  

⚠️ These are local development credentials only. Never use a blank root password on a live server.

5. Make sure the upload folder exists

6. Run the app

Visit: http://localhost/251301_creative_webapp/pages/login_page.php

Click Register, create an account, then log in.

Features
<!-- Add a screenshot or GIF for every feature. Suggested file names are shown. -->
# Feature	What it does	Preview
Register and login	Create an account with validation; log in with username or email	Register
Secure passwords	Passwords are hashed with password_hash() and checked with password_verify()	–
User dashboard	Shows your profile details and the items you have listed	Dashboard
Add an item	Name, description, category, condition and an image upload (JPG, PNG, GIF, WEBP)	Add item
Marketplace	Browse every available item from other students, newest first	Marketplace
Item details	See the full item information and owner, and request a trade	Item details
Send trade requests	Request an item; you cannot request your own item or send duplicate requests	Trade request
Manage requests	See incoming and outgoing requests; owners can accept or reject	Trade requests
Delete item	Owners can remove their own listings	–
Responsive design	Works on desktop, tablet and mobile	Responsive
Responsive views

Development Process
Planning and design
Idea: [Why you chose a trading app – e.g. students have items they no longer need, and trading is more fun and cheaper than buying.]
Design: [Link to your Figma / wireframes.] Add your wireframes here:
Wireframe	Final result
Wireframe	Final


Architecture

The app follows a simple page-controller structure: each PHP page handles its own request, talks to MySQL through one shared PDO connection, and returns HTML.

HTTP request
PDO prepared statements
uploaded_file
HTML response
BrowserHTML / CSS / JS
Apache + PHPpages/*.php
MySQLcreative_app

Folder structure

251301_creative_webapp/
├── assets/            # CSS, images, SVGs
│   └── css/           # auth, dashboard, item-details, add-item, trade-request...
├── database/
│   └── db.php         # PDO connection (shared by every page)
├── includes/          # header.php (nav + session), deco-circles.php
├── js/                # client-side validation (login, register, landing)
├── pages/             # login, register, marketplace, add_item, trade logic...
└── uploads/items/     # uploaded item photos


1. Secure registration (hashing + prepared statement)

php
$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (username, email, password)
     VALUES (:username, :email, :password)"
);
$stmt->execute([
    ':username' => $Jack,
    ':email'    => $jack@1234,
    ':password' => $hashed
]);

Why: passwords are never stored in plain text, and prepared statements protect against SQL injection.

2. Login with session protection

php
if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);          // stops session fixation
    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];
}

3. Only the owner can accept a trade

php
// Only the item's owner can accept the request
if ((int) $request['owner_id'] !== $user_id) {
    header("Location: trade_requests.php");
    exit();
}
// Only pending requests can be accepted
if ($request['status'] !== 'pending') {
    header("Location: trade_requests.php");
    exit();
}

Why: the check happens on the server, so a user cannot accept a trade just by editing the page in their browser.

4. Safe image uploads

php
$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$new_filename = uniqid('item_', true) . '.' . $extension;   // unique name, no overwriting
Challenges and solutions
Challenge	How I solved it
Stopping users from requesting their own item or sending duplicates	Added server-side checks in request_trade.php (owner check, availability check, existing pending request check)
Users accessing pages without logging in	Every protected page checks $_SESSION['user_id'] and redirects to login
Image uploads overwriting each other	Generated a unique file name with uniqid() and limited the allowed file types
[Add your own, e.g. CSS layout / responsive issues]	[How you fixed it]
[Add your own, e.g. debugging with AI help]	[What the error was and what you learned]
Testing

Manual testing was done against these scenarios (tick the result after you test each one):

#	Test	Expected result	Pass
1	Register with mismatched passwords	Error: "Passwords do not match"	
2	Register with an existing username/email	Error: "Username or email already exists"	
3	Log in with wrong password	Error: "Invalid username or password"	
4	Open marketplace.php while logged out	Redirected to login	
5	Upload a .pdf as an item image	Rejected with an error message	
6	Request your own item	No request is created	
7	Request the same item twice	Second request is blocked	☐
8	Another user tries to accept your request (change the ID in the form)	Redirected, status unchanged	
9	Accept a request	Request = accepted, item = traded, item leaves marketplace	
10	View on a phone-sized screen	Layout adapts, nothing overflows	
<!-- Add a screenshot of any error messages or your phpMyAdmin tables as proof -->

Database in phpMyAdmin

Final Outcome
Demo video
<!-- Upload the video to YouTube (Unlisted) or Google Drive and paste the link. --> <!-- Don't commit the .mp4 file itself - this repo's .gitignore blocks *.mp4. -->

Watch the demo


Deployed link


Conclusion
Highlights
Built a complete trade workflow (list → browse → request → accept/reject) from scratch
Implemented secure authentication using password hashing, prepared statements and session regeneration
Enforced ownership and permission rules on the server, not just in the interface
Delivered a responsive design that works across devices
What I learned
How PHP sessions, PDO and MySQL work together in a real application
Why validation and permission checks must happen on the server a void

Future improvements
Let users offer one of their own items in exchange (true swapping) instead of just requesting
Automatically reject other pending requests once an item is traded
Add user profile pictures and public profile pages
Add search and category filters on the marketplace
In-app messaging between traders
Email notifications for new trade requests
Add a CSRF token to every form
Deploy online (e.g. Azure App Service with a managed MySQL server)
License


Contact

[Khanyisile Manana]

Email: [khanyimanana567@gmail.com]
GitHub: @Khanyi20
Acknowledgements
Resource	Used for
XAMPP	Local Apache, PHP and MySQL environment
PHP Manual	PDO, sessions, password_hash reference

<p align="right"><a href="#trade-or-drop">⬆ Back to top</a></p>

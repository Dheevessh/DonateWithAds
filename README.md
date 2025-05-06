# DonateWhileWatching

A responsive, mobile-friendly charity website that allows users to vote for a charity after watching an ad. At the end of each month, 50% of the ad revenue is donated to the most-voted charity.

## Features

- **Ad-Watching System**: Users watch ads to earn votes for charities
- **Voting System**: One vote per email per 10 ads watched
- **Email Collection**: Captures user emails for voting verification
- **Real-time Vote Counts**: Live standings visible on the site
- **Admin Dashboard**: Manage charities, view users, and reset votes monthly

## Installation

1. Clone the repository to your web server:
   ```
   git clone https://github.com/yourusername/DonateWithAds.git
   ```

2. Set up a MySQL database and import the schema:
   ```
   mysql -u username -p your_database_name < sql/schema.sql
   ```

3. Configure the database connection in `includes/config.php`:
   ```php
   define('DB_HOST', 'your_host');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'your_database_name');
   ```

4. Update the site URL in `includes/config.php`:
   ```php
   define('SITE_URL', 'http://your-domain-or-localhost-path');
   ```

5. Make sure your web server supports PHP (7.4+ recommended) and has the MySQLi extension enabled.

6. Set appropriate permissions on the files and folders.

## Usage

### User Flow

1. Visit the homepage to learn about the site's mission
2. Navigate to the voting page to watch an ad
3. After watching the ad, enter an email (required only once)
4. Select a charity and submit the vote
5. After 10 ads, users can submit another vote

### Admin Access

1. Access the admin panel at `/admin/login.php`
2. Default credentials: 
   - Username: admin
   - Password: admin123 (change this in production!)
3. Use the admin dashboard to:
   - View vote statistics
   - Manage charities (add, edit, delete)
   - View user list
   - View all votes
   - Reset votes at the end of each month

## Directory Structure

- `/public`: Frontend files accessible to users
- `/admin`: Admin interface files
- `/includes`: Database connection and utilities
- `/sql`: Database schema

## Customization

- Modify the design in `public/css/styles.css`
- Update ad behavior in `public/js/main.js`
- Add real ad code by editing the placeholder in `public/vote.php`

## Security Considerations

- Change the default admin password immediately
- Consider implementing rate limiting for voting
- Add CAPTCHA to prevent bot submissions
- Regularly back up your database

## License

This project is open source and available under the [MIT License](LICENSE).

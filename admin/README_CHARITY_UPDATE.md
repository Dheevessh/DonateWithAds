# Charity Update Instructions

## Overview
This directory contains scripts to update the list of charities in the database. The updated charity list includes:

1. National Cancer Society Malaysia (NCSM)
2. PAWS Animal Welfare Society
3. Charity Right Malaysia
4. Islamic Relief Malaysia – Palestine Appeal
5. Cinta Gaza Malaysia (CGM)

## How to Update Charities

### Step 1: Images
For each charity, you should place appropriate images in the `public/images/` directory:
- `charity_ncsm.jpg` - National Cancer Society Malaysia
- `charity_paws.jpg` - PAWS Animal Welfare Society
- `charity_right.jpg` - Charity Right Malaysia
- `charity_islamic_relief.jpg` - Islamic Relief Malaysia
- `charity_cinta_gaza.jpg` - Cinta Gaza Malaysia

The site logo is also stored in the same directory:
- `donatewhilewatching.jpg` - Main website logo, displayed in the navigation bar

If the images aren't available, the site will use placeholders automatically.

### Step 2: Update the Database
1. Log in to the admin panel
2. Navigate to `update_charities.php` to run the update script
3. Verify the update by checking the charities list at `charities.php`

### Important Notes
- The script will delete all existing charities and replace them with the new list
- All existing votes for the previous charities will remain in the database but won't be associated with any charity
- You may want to back up your database before running this script if you want to preserve votes for the old charities

## SQL Details
The SQL file (`sql/update_charities.sql`) performs the following operations:
1. Deletes all existing charity records
2. Resets the auto-increment counter
3. Inserts the 5 new charities

If you need to make further adjustments to the charity list, edit the SQL file directly. 
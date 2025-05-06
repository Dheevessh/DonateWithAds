-- Delete existing charities
DELETE FROM charities;

-- Reset auto-increment counter
ALTER TABLE charities AUTO_INCREMENT = 1;

-- Insert new charities
INSERT INTO charities (name, description, image_url) VALUES
('National Cancer Society Malaysia (NCSM)', 'Dedicated to cancer prevention, education, and support services. Donate directly at: <a href="https://cancer.org.my/" target="_blank" class="text-blue-600 hover:underline">https://cancer.org.my/</a>', 'images/charity_ncsm.jpg'),
('PAWS Animal Welfare Society', 'Located in Petaling Jaya, Selangor, PAWS provides shelter to unwanted dogs and cats, offering them medical care and facilitating adoptions. Donate directly at: <a href="https://www.paws.org.my/donate/" target="_blank" class="text-blue-600 hover:underline">https://www.paws.org.my/donate/</a>', 'images/charity_paws.jpg'),
('Charity Right Malaysia', 'Provides long-term food aid to underprivileged communities, emphasizing education. Donate directly at: <a href="https://legacy.simplygiving.com/NonProfit/charityrightmalaysia" target="_blank" class="text-blue-600 hover:underline">SimplyGiving</a>', 'images/charity_right.jpg'),
('Islamic Relief Malaysia – Palestine Appeal', 'Provides emergency humanitarian assistance to Palestinians affected by ongoing conflicts. Current goal: RM1.5 million; over RM300,000 raised so far. Donate directly at: <a href="https://islamic-relief.org.my/palestine-appeal/" target="_blank" class="text-blue-600 hover:underline">https://islamic-relief.org.my/palestine-appeal/</a>', 'images/charity_islamic_relief.jpg'),
('Cinta Gaza Malaysia (CGM)', 'Focuses on socio-economic development in Gaza, including emergency aid and sustainable projects. Accepts donations via Maybank and online platforms. Donate directly at: <a href="https://donate.infakpalestin.com/" target="_blank" class="text-blue-600 hover:underline">https://donate.infakpalestin.com/</a>', 'images/charity_cinta_gaza.jpg');

-- If you need to add more charities, add them here following the same pattern 
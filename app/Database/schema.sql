-- Birmingham 2027 Admin Panel - foundation schema

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login_at DATETIME NULL,
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_role (role),
    KEY idx_users_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default super admin (password: ChangeMe123!) - change immediately after first login.
    -- INSERT INTO users (name, email, password_hash, role) VALUES
    --   ('Super Admin', 'admin@example.com', '$2y$10$replace-with-real-hash', 'super_admin');

CREATE TABLE IF NOT EXISTS visa_requests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(190) NOT NULL,
    email VARCHAR(190) NOT NULL,
    date_of_birth DATE NOT NULL,
    home_address TEXT NOT NULL,
    return_confirmation TINYINT(1) NOT NULL DEFAULT 0,
    church_name VARCHAR(190) NOT NULL,
    church_address TEXT NOT NULL,
    pastor_name VARCHAR(190) NOT NULL,
    pastor_email VARCHAR(190) NOT NULL,
    passport_number VARCHAR(50) NOT NULL,
    passport_issue_date DATE NOT NULL,
    passport_expiry_date DATE NOT NULL,
    consulate_country VARCHAR(100) NOT NULL,
    passport_country VARCHAR(100) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_visa_requests_passport_country (passport_country)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dummy/fictional records for testing the admin interface only.
INSERT INTO visa_requests
    (full_name, email, date_of_birth, home_address, return_confirmation, church_name, church_address, pastor_name, pastor_email, passport_number, passport_issue_date, passport_expiry_date, consulate_country, passport_country)
VALUES
    ('Jane Doe', 'jane.doe@example.com', '1990-04-12', '12 Fictional Lane, Sampleton, SA1 2BC', 1, 'Grace Fellowship Church', '4 Church Road, Sampleton, SA1 4DE', 'Pastor John Sample', 'pastor.john@example.com', 'P1234567', '2019-06-01', '2029-06-01', 'Nigeria', 'Nigeria'),
    ('Christopher Alexander Worthington-Fairweather III', 'christopher.worthington-fairweather@example.com', '1985-11-23', 'Apartment 42B, The Old Millhouse, 128 Long Winding Boulevard, Upper Sampleford-on-the-Hill, Greater Exampleshire, EX4 9ZZ, Somewhereland', 0, 'International Grace Tabernacle of the Redeemed Assembly', 'Unit 7, Faithbuilders Business Park, 200 Ministry Avenue, Exampleshire, EX9 1AA', 'Reverend Doctor Nathaniel Ebenezer Highchurch-Whitmore', 'reverend.highchurch-whitmore@example.com', 'X9988776655', '2021-01-15', '2031-01-15', 'Ghana', 'Ghana')
;


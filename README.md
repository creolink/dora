# What is it about
DORA Metrics Application

# Mandatory software
- PHP 8.1
- PHPUnit 9.5
- MySQL 5.7
- Composer (latest version)
- php-cs-fixer (take a look below how to install it)
- "ext-uopz extension" for "ClockMock" - install it with `pecl install uopz` (https://github.com/krakjoe/uopz/blob/master/INSTALL.md)


# Local environment setup
1. install php 8.1 with brew
2. setup webhooks
   - https://docs.github.com/en/webhooks-and-events/webhooks/creating-webhooks
   - get token from https://dashboard.ngrok.com/get-started/your-authtoken
3. 


Helpers:
 - https://github.com/slope-it/clock-mock for mocking time in tests
# Calculator PHP - POC

This is simply a POC. I have kept it separate from the Calculator app to prevent pollution as I don't feel this is anywhere near ready to being included yet.

# Installation

## Clone project
Via your command line tool, navigate to the root of your 'sites' directory. This will be the location you store your projects.

Paste the following command and hit `enter`.

```
git clone git@github.com:danwarman/calculator-php.git
```

## Go in to the project
Via your command line tool, navigate into the root of the calculator project.
```
cd calculator-php
```

# Run the POC
1. Run following command.

```
php -S localhost:9000
```

> **Note.**
> - **Requires PHP** to be installed locally. See [www.php.net/manual/en/install.php](https://www.php.net/manual/en/install.php) for instructions.
> - Choice of port (`9000`) is up to you.

2. Now go to this address in your browser ([http://localhost:9000](http://localhost:9000)).

# Using the POC
To mimic the **SAVE** button on the calculator, enter a result (`number`) in to the input the click the `SAVE` button.

This executes a call to `Calculations.php` which in turn creates / updates a CSV: `calculations.csv`.

If you navigate to `/Calculations.php` (eg. [http://localhost:9000/Calculations.php](http://localhost:9000/Calculations.php)) in your browser, you will see an array of the results from that CSV.

## CSV Headers
- **ip**
  - IP address from the TCP/IP layer.
- **forwarded_ip**
  - If using a proxy or forging their headers - capture just incase it's useful.
- **user_agent**
  - Full user agent - added because it contains browser information and I don't have `browscap.ini` sorted locally.
- **browser**
  - Would use `getbrowser()` to return browser instead of just the user agent but as per above, I don't have `browscap.ini` sorted locally.
- **result**
  - The number the user entered in to the input
- **created_at**
  - Timestamp at the time of insertion. Stored in MySQL format.
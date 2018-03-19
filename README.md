# Raspi-Temp
###  PHP coded with bits of python and JS
##### Getting greater and greater (also good looking ;) )

### Raspi Temp
is a home project which is helping very much in with the temperature measurement through the complete house with the **1-Wire BUS** including the **DS18S20 (10)** and **DS18B20 (28)** digital thermometers _(The code is mostly written to overcome all those restrictions with IDs, because they're added inside the **DB** and then read in each script again)_ Most part is coded in **PHP** and **python (GPIO)** back-end while **JS** doing some front-end magic. This project is **still in development**, but im sharing this code here for everyone who helped me once with his code in forums or on Github. Hope this helps out and yes if you find an issue don't hesitate to report it to me so i can work out a fix for it and make this much better!

## Overview
```
  index.php                 -- forwarder to currently used project folder
  do_json.php             -- ignore it, just stays there for some commits.. :D
  raspi_temp_beta\        -- currently used main folder (holds stacks of each other folder inside)
  raspi_temp_beta_new\    -- bootstrap beginning, currently _out-of-sync_
  raspi_temp_beta_test\    -- most sync with raspi_temp_beta _(developed in beta_test and sync over to beta)_
  raspi_temp_dev\            -- combination of beta_test and beta_new, same as beta_new _out-of-sync_
  test\                    -- JQUERY UI files - holding up for later ;)

  raspi_temp_beta \index.php             -- holds menu buttons for easy access to each page 
                  \theme.php             -- test file for changing theme overlay
                  \highchart.php         -- creating long time chart _(laying there because of some ajax tests, some time ago)_
                    \conf\icon            -- icon folder for index buttons
                         \scripts        -- JS script directory
                         \styles        -- CSS directory
                    \pages\img\            -- button images for a gpio script found on github _(don't found it tho..)_
                          \old\            -- some gpio control sites which are kept there for later code _copy & pastery_
                          \php\            -- holds most of the php magic _(gonna explain it more when needed)_
                          \temps\        -- temporary folder for iframe windows which are beeing added in live_data3.php
                          \.php         -- combining most of the files in php\ to create some nicely working sites
                          \_all-the-other-files -- menu buttons or just log / bak or test sites with are just there for easy access_
                    \sql                -- holding the SQL files for the DB **(insert manually atm)**
```
## Planned
As you may can read it out of the overview there are many things planned but now to some others which didn't seem so clearly to find
 *  more AJAX! Throwing out the temps dir
 *  more configurations for the thermometers
 *  easier access to settings and better overview _(bootstrap)_
 *  _(staying)_ responsive, my sites are currently working good on mobiles _(not perfect sadly)_
 *  move cronjobs to php to get better control of sheduled tasks
 *  many, many things more...
 *  ICON! D:

 ## Contact
 You can always open an issue and i'll response!

 ## I'm
 Ghostychan, Owner of Digital-Ghosts.at | Programmer & Gamer & Happily inlove with my Baechun ♥
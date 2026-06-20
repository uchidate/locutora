# Changelog

## 1.9.3 (January 25, 2023)

- Fix time format used across Access and Forms addons.
- Fix form actions execution when conditioned with submission data.

## 1.9.2 (January 13, 2023)

- Fix Forms Checkbox HTML5 validation when is not multiple.
- Fix Input datetime elements default value resolving to now.
- Fix Dynamic runtime performance when inheriting query.
- Fix Dynamic UI responsiveness when using custom query.
- Fix Dynamic UI compatibility issue with YTP 3.0.21.

## 1.9.1 (December 22, 2022)

- Add target attr setting for Social Sharing MailTo.
- Fix new sources image caching.

## 1.9.0 (December 21, 2022)

- Add RSS Source.
- Add Twitter Source.
- Add Facebook Source.
- Add Instagram Business Source query Date filters.
- Add Instagram Source Single Media Query and album media edge.
- Add Vimeo Source My Folder Videos query.
- Add Vimeo Source My Showcase Videos query.
- Add attributes support to forms Option element (Checkbox, Radio, Select).
- Fix hCaptcha double validation with Checkbox type.

## 1.8.14 (December 9, 2022)

- Fix Forms style regression.
- Fix Forms Input element Predefined Value processing.

## 1.8.13 (December 1, 2022)

- Add local caching for Google Profile source media.
- Fix PHP warnings.
- Fix sources media caching.
- Fix Forms accessibility issues.
- Fix Customizer UI performance issue.

## 1.8.12 (November 15, 2022)

- Add form FriendlyCaptcha EU endpoint.
- Add better pagination support for Instagram Source.
- Fix YTP 2.x UI regression.
- Fix form upload element width/size styling.
- Fix form upload element mimetype validation check (security vulnerability).
- Fix form actions being executed even if disabled.
- Fix form saveTo actions data mapping if some columns disabled.
- Fix fatal error if a Layout Library storage is deleted.

## 1.8.11 (November 10, 2022)

- Fix Access date rules regression.

## 1.8.10 (November 9, 2022)

- Fix Access evaluation regression.

## 1.8.9 (November 8, 2022)

- Add form Data action.
- Add Access conditions custom logic evaluation and logs.
- Add option to update an existing record with form Database action.
- Add option to disable a field being mapped in SaveTo form actions.
- Fix datetime picker manual date input.
- Fix Access time rule timezone evaluation.
- Fix double icons loading (Joomla).
- Fix Database source relations (WordPress).

## 1.8.8 (October 26, 2022)

- Add support for form fields dynamic validation values.
- Add Show Label control for form fields wrapped in a Fieldset.
- Add support for min/max selection count validation on Checkbox & Select.
- Change distribution of form elements settings.
- Change Instagram Source into separate sources for Personal and Business accounts.
- Change YouTube Source into separate sources for Channel and Playlist.
- Fix Dynamic workflow regression.
- Fix plugin activation hook (WordPress).
- Fix Download action file path resolving.
- Fix access conditions custom name display.

## 1.8.7 (October 20, 2022)

- Fix YTP 3.0.7 compatibility issue.

## 1.8.6 (October 19, 2022)

- Fix PHP 8 deprecation warnings.
- Fix 1.8 transition related issues.
- Fix theme version check (WordPress).
- Fix Instagram Source media local caching.
- Fix form node arguments overriding globals.

## 1.8.5 (September 30, 2022)

- Add Page queries as dynamic option.
- Add YouTube source query offset argument.
- Fix config save regression (WordPress).

## 1.8.4 (September 27, 2022)

- Fix YTP 3 compatibility issues.

## 1.8.3 (September 26, 2022)

- Fix global queries and other UI related issues.
- Fix support for multi value form elements during dynamic mapping.

## 1.8.2 (September 20, 2022)

- Fix customizer regressions.
- Fix saveToCSV action support for custom separator/enclosure.

## 1.8.1 (September 17, 2022)

- Fix saveTo actions update script.
- Fix SaveToDatabase action support for external databases.

## 1.8.0 (September 14, 2022)

- Add SaveToDatabase after submit action.
- Add Dynamic Content support to after submit actions.
- Add option to disable form inputs inheriting the ID from the control name.
- Fix form actions PHP warning when evaluating execution conditions.
- Fix Form Area customizer status when there are multiple areas.
- Change form elements settings distributtion.

## 1.7.7 (September 5, 2022)

- Add support for a form class attribute.
- Add support for multiple form submit buttons.
- Add support for datetime comparison in Dynamic Access rule.

## 1.7.6 (August 26, 2022)

- Fix error for auths with no threshold set.

## 1.7.5 (August 24, 2022)

- Add form Friendly Captcha anti-spam solution.
- Fix mailer 'sent from' support.
- Fix TikTok authentication workflow.
- Fix form hCaptcha custom error & label output.
- Fix form reCaptcha multiple instances & custom error output.
- Fix selecting presets from a custom Layout Library.
- Fix form date/time input validation when a min or max range is set.

## 1.7.4 (August 15, 2022)

- Add UIkit List style modifiers support for Markdown element List Blocks.
- Add Legend position, align and reverse settings for Chart element configuration.
- Fix auth renewal token workflow.
- Fix YTP 3.b5 compatibility issue.
- Fix Markdown element nested list block rendering.

## 1.7.3 (August 10, 2022)

- Fix YTP 3.b4 compatibility issue.
- Fix form fields listing in actions settings panel.

## 1.7.2 (July 26, 2022)

- Add support for loading collection icons set in Menu Items.
- Change Form Upload filename overwrite, the extension must be excluded now.
- Fix offset execution of time and datemodify source filters.
- Fix includes evaluation of the access dynamic condition.

## 1.7.1 (July 14, 2022)

- Fix edge issue affecting core source transform.

## 1.7.0 (July 12, 2022)

- Add Dynamic Addon 🥳

## 1.6.14 (July 11, 2022)

- Add Instagram User Source query type.
- Fix S3 Storage connection.
- Fix form init when assets are being combined.

## 1.6.13 (June 21, 2022)

- Fix regression affecting updates workflow.

## 1.6.12 (June 21, 2022)

- Fix UI regression affecting form actions.

## 1.6.11 (June 16, 2022)

- Add Social Sharing element Xing network.
- Add Social Sharing element Telegram network.
- Add ValueInput setting for Google Sheet saveTo form action.
- Add Google MyBusiness review comment translation fallback.
- Add a Datetime picker field for the customizer.
- Change and simplify Date/time access rules using the new Datetime picker.
- Fix Social Sharing URL encoding.
- Fix SaveTo actions skipping empty fields.
- Fix reCaptcha form field assets execution.
- Fix Google MyBusiness multiple queries support.
- Fix double wp_once input ids in wordpress forms.

## 1.6.10 (May 19, 2022)

- Fix PHP warning regression.

## 1.6.9 (May 17, 2022)

- Add IP Geolocation access rule.
- Add random ordering for Database Source.
- Fix form empty tags parsing.
- Fix form Email Action plain text body parsing.
- Fix issue with form rendering on first page load after clearing cache.

## 1.6.8 (April 20, 2022)

- Add Vimeo Content Source.
- Add hCaptcha form element.
- Add HTML line breaks support for forms data placeholders.
- Fix Layouts Manager renaming action.
- Fix Google My Business source AverageRating resolving.

## 1.6.7 (April 6, 2022)

- Fix icon loading regression.
- Fix edge PHP error in Google Spreadsheet source.

## 1.6.6 (April 5, 2022)

- Fix UI regressions.

## 1.6.5 (April 4, 2022)

- Add Google reCaptcha v3 custom Score Threshold support.
- Fix Google reCaptcha v3 not considering Score in validation.
- Fix assets build issue introduced in previous release.

## 1.6.4 (April 1, 2022)

- Fix Google Sheet Source columns start/end implementation.
- Change Icon Collections location, merged into the Essentials Menu.

## 1.6.3 (March 24, 2022)

- Fix Customizer UI issues.
- Fix Layouts Library presets loading.
- Fix Instagram and TikTok OAuth token renewal.

## 1.6.2 (March 19, 2022)

- Fix Freemium build.
- Fix YouTube API MaxResults filter being ignored.
- Change YouTube cache minimum time to 3600 for all OAuth based queries.

## 1.6.1 (March 17, 2022)

- Fix Auth issues.
- Fix Builder fields loading.

## 1.6.0 (March 16, 2022)

- Add Layouts Addon 🥳
- Add Storages module.
- Add Essentials unified menu.
- Add Settings Import/Export option.
- Add About Section.

## 1.5.16 (March 15, 2022)

- Add support for Multiple Items Source on Access Rules dynamic configuration.
- Fix Forms Action SaveToGoogleSheet missing Sheet Name warning.
- Fix Google Sheet Source schema issue when using multiple instances.

## 1.5.15 (March 9, 2022)

- Fix DB connection error handling (WordPress).
- Fix CSV Source Record filter/order missing field.
- Fix Forms Email Action multiple value placeholder parsing.

## 1.5.14 (February 23, 2022)

- Add Dynamic as a new Access Rule.
- Fix vendor build issues introduced in previous release.
- Fix Social Sharing MailTo query encoding.

## 1.5.13 (February 22, 2022)

- Add Week as a new Access Rule.
- Add Font Awesome 6 Free as a new Icon Collection.
- Fix Social Sharing MailTo query encoding.

### Forms

- Add support for placeholder replacement in Email Action static attachments path.
- Add options to set a custom filename and avoid collisions for Submitted Files on Upload Field.
- Fix Web Accessibility issue.
- Fix html entities encoding for Options based fields.

## 1.5.12 (February 7, 2022)

- Fix Google My Business source comment resolving.
- Fix Email After Submit Action *from* and *from name* settings handling.
- Fix CSV source not working with Dynamic Content based filters.
- Fix Forms validation issue on servers not respecting response code.
- Change main Icons Collections to no longer be auto-fetched (WordPress).

## 1.5.11 (January 28, 2022)

- Fix Social Sharing MailTo query encoding.
- Fix YouTube API max results filter.
- Fix Form ID generation related issues.

## 1.5.10 (January 19, 2022)

- Add support for Form Fields data placeholders in Redirect After Submit Actions.
- Fix external images caching.
- Fix Google My Business source Original Comment resolving.
- Fix Forms Config Cache and Submission issues.

## 1.5.9 (January 7, 2022)

- Fix PHP egde warnings.
- Fix icons listing for MyIcons collection.
- Fix Auth grants returning no granted scopes.
- Fix Form Input field rendering settings being ignored.
- Fix Google My Business source comment resolving.

## 1.5.8 (November 30, 2021)

- Add Form Actions status setting.
- Add Start and Before Than filters for TikTok source video query.
- Fix Checkbox form field validation.
- Fix Limit argument being ignored in TikTok video query.
- Fix Dynamic Values compatibility with certain Access Rules.
- Fix Form Uploads final paths returned as absolute.

## 1.5.7 (November 11, 2021)

- Add support for dynamic file path to form Download action.
- Fix Builder Foot Layout editing affected by form rendering.

## 1.5.6 (November 5, 2021)

- Fix regression introduced in previous release.

## 1.5.5 (November 5, 2021)

- Fix fields mapping issues with TikTok source.

## 1.5.4 (November 3, 2021)

### Forms

- Add Form ID & Name attributes settings.
- Fix Form Download action.
- Fix Form Radio field HTML 5 validation.

### Sources

- Add API Key based Advanced Query for YouTube source.
- Add Date Modify filter to Request source Timestamp mapping field.
- Add Reviews Link, Original Review, and Translated Review fields mapping for Google My Business source.
- Fix business open hours query for Google MyBusiness source.

## 1.5.3 (October 22, 2021)

- Fix Forms Actions regression.
- Fix core sources ID resolving (WordPress).
- Fix CSV Source default ordering and headers encoding issue.
- Change YouTube API calls to mitigate quota limits.

## 1.5.2 (October 15, 2021)

- Fix Forms Actions migration script.
- Fix CSV Source header names display when listed in filter/ordering conditions.

## 1.5.1 (October 14, 2021)

- Fix CSV Source encoding regression.
- Fix Google My Business locations list limit.

## 1.5.0 (October 14, 2021)

### Sources

- Add TikTok source.
- Add YouTube source.
- Add Request source.
- Add Google MyBusiness source.
- Add Cloudflare Stream source.
- Add Filter/Order query conditions to CSV Source.
- Add Hashtagged Media query to Instagram Source.

### Forms

- Add After Submit Action 'Save to Google Sheet'.
- Add ID attribute to all fields control.

### Access

- Add 'User' Access Rule - Validates if the current user matches the stated ID/Username.

## 1.4.10 (October 11, 2021)

- Fix Chart Element missing enclosing div.
- Fix Email Action test email execution.
- Fix Access rules mapping with Dynamic Sources data.
- Fix Warning if initial Icon Collections fail to download (WordPress).

## 1.4.9 (October 4, 2021)

- Fix update transform warning.

## 1.4.8 (September 30, 2021)

- Fix Form field tags not being removed when replacement is not found in the submission data.
- Fix regression introduced in previous release.

## 1.4.7 (September 21, 2021)

- Fix Sources field name edge case encoding issue.
- Fix Icon Picker filter not resetting the group when switching collection.

## 1.4.6 (September 13, 2021)

- Fix Chart Element general container settings not being applied.
- Fix Google Sheet Source not considering custom cache time setting.

### Forms

- Fix Upload field support for multiple file uploads.
- Fix Email Action not sending text/plain alternative body when in HTML mode.
- fix Email, Tel, and URL form fields support for pattern attribute.

## 1.4.5 (August 31, 2021)

- Fix Icon loading issues.

### Forms

- Fix Honeypot field validation.
- Fix Upload field support for spaces in control name.

## 1.4.4 (August 20, 2021)

- Fix send email test workflow for Email form action.
- Fix compatibility with YOOtheme Pro 2.6 GraphQL dependency.
- Remove ZipArchive PHP extension dependency.

## 1.4.3 (August 11, 2021)

- Fix issue on Database source when linking more than one relation to the same field.
- Fix issue on Database source when using filtering/ordering on external database.
- Fix UI issue affecting Access Rules modal.

## 1.4.2 (August 4, 2021)

- Fix Source Types extension issue (Joomla).

## 1.4.1 (August 4, 2021)

- Fix Source Types extension issue (WordPress).

## 1.4.0 (August 3, 2021)

### Sources

- Add Table Relations and Single Record Query for Database Source.
- Add Filters and Ordering conditions for Database Source Queries.

### Forms

- Add Source support for most form elements fields.

### Access

- Add composable conditions with AND/OR logic.
- Add Source support for rule dynamic values.
- Add possibility to name a rule.
- Add possibility to disable a rule
- Add possibility to revers rule evaluation.

### Elements

- Add Social Sharing MailTo item.
- Add Social Sharing Viber item.
- Add Table and List blocks support for Markdown element.

## 1.3.6 (August 3, 2021)

- Fix error triggered if a CSV Source file is missing.

## 1.3.5 (July 28, 2021)

- Fix warning triggered by Icon Loader.
- Fix invisible reCAPTCHA regression introduced in v1.3.4.

## 1.3.4 (July 13, 2021)

- Fix multiple Form support when using reCAPTCHA.
- Fix language listing for Access Language rule (Joomla).

## 1.3.3 (July 1, 2021)

### Sources

- Fix Limit filter being ignored in DB Source.

### Forms

- Fix Email field allowing whitespaces where it should not.
- Fix Download action not redirecting properly.

## 1.3.2 (June 29, 2021)

- Fix Instagram Source raw media url.
- Fix on save config warning.

## 1.3.1 (June 28, 2021)

### Sources

- Fix Database Source fields keys encoding.
- Fix Database Source external connection support.
- Fix Instagram Source image caching for videos media.

### Forms

- Fix Builder Form Area quick edit access link.

### Icons

- Fix Icon Collections loading and UI inconsistencies.

### Elements

- Fix Chart Element dimension enforcement & deferred init.

## 1.3.0 (June 23, 2021)

- Add support for overriding OAuth settings allowing the usage of custom Apps.
- Add Settings -> Auths section for managing authentications and secrets in one place.
- Add more transparency about what permission scopes are required in an OAuth authentication.

### Sources

- Add Hashtags mapping field for Instagram Source.
- Add resizing support for Instagram Source image media.
- Add Comments Count and Like Count mapping fields for Instagram Source (Business Accounts).
- Add Date and Content Limit filters for Timestamp and Caption Instagram Source mapping fields.
- Add external DB connection support for Database Source.
- Add support for specifying a Sheet Name in addition to the Spreadsheet for Google Sheet source.

### Forms

- Add after submit action, Download.
- Add From Name for Email action settings.
- Add Timeout and Open in New Window settings for after submit action Redirect.
- Add Honeypot field, a CAPTCHA alternative for blocking spam.

### Icons

- Add Icons List view and other UI improvements to the Builder Icons Picker.
- Add Collections Manager with on-demand installation (Icons are not included in the build anymore).
- Add new collections (Ant Design, Bootstrap, Boxicons, Feather, Octicons, Remix Icon & Tabler Icons).

## 1.2.11 (June 23, 2021)

### Sources

- Fix Instagram media type filtering not including Carousel Albums.

### Forms

- Fix issue with Google reCAPTCHA when HTML5 validation is disabled and server validation fails.

## 1.2.10 (June 1, 2021)

### Forms

- Fix recaptcha regresion introduced in 1.2.8.
- Fix Email action Send as HTML setting default value.
- Change Message action Modal as alert instead of dialog (reversed again).

## 1.2.9 (May 18, 2021)

- Fix Chart element data encoding being affected in some edge configurations.
- Fix unwanted downgrades when auto-updating (Joomla).

## 1.2.8 (May 16, 2021)

### Sources

- Remove Instagram unsupported mapping fields (comments_count & like_count).

### Forms

- Fix recaptcha not working when used in multiple forms on the same page.
- Fix form being reset too early affecting submissions with custom action url.

## 1.2.7 (April 28, 2021)

- Fix PHP warning related to automatic updates (WordPress).

### Sources

- Fix Google Sheet warning when loading an empty spreadsheet.
- Fix Google Sheet content caching.
- Fix Instagram refresh token issue.

### Icons

- Fix icons collections build.
- Fix invalid cache key warning.

## 1.2.6 (April 13, 2021)

### Forms

- Add Horizontal layout for Checkbox & Radio fields.
- Add Grid Columns setting for the form input field.
- Fix Builder form fields listing.
- Fix SaveToCSV multi options fields parsing.
- Fix form rendering after cache clearance.

## 1.2.5 (April 7, 2021)

- Fix conflicts with 3rd-parties dependencies.

### Sources

- Add configuration pre saving tests.
- Fix broken mapping after some configuration changes.

### Forms

- Change actions JavaScript hooks workflow.
- Fix Checkbox Field validation.
- Fix email action attachments support.
- Fix quick access to Form Area Builder settings.

## 1.2.4 (March 27, 2021)

- Fix Forms settings being deleted when Form Area is disabled.

## 1.2.3 (March 25, 2021)

- Fix UI regression.
- Fix Form Date field min/max attributes support.
- Change YOOtheme Pro min version to 2.3.32.

## 1.2.2 (March 21, 2021)

- Fix general UI issues.

### Forms

- Add support for fields Tag Replacement in Upload field upload path.
- Fix Email Action sending test & attachments related issues.

## 1.2.1 (March 13, 2021)

- Change YOOtheme Pro min version to 2.3.18.

### Forms

- Fix Checkbox Field values submission.

### Icons

- Fix Icons picker loader regression.

## 1.2.0 (March 10, 2021)

- Add Sources Addon 🥳

### Forms

- Add support for spaces in field names.
- Add support for custom action url and method.
- Add a simple send email test for Email action.
- Add Columns configuration for SaveToCSV action.
- Add optional name field to actions for easier identification.
- Add configuration quick access through the Status Icon (requires YTP 2.3.26 or above).
- Add support for empty value and disabled attribute in Option fields (Select, Radio, Checkbox).
- Add support for Submission Tag Replacement on missing Email Action fields (ccs, bccs, reply_tos, from).
- Change Message action to use UIkit Modal dialog instead of alert.

### Access

- Add Datetime access rule.
- Add configuration quick access through the Status Icon (requires YTP 2.3.26 or above).
- Change User Access rule to display Guest setting as a role (WordPress).

### Elements

- Add Pinterest Social Sharing network.
- Add Social Sharing popup window option.

## 1.1.8 (March 9, 2021)

- Fix session handler (WordPress).

### Forms

- Fix upload validation and edge configuration issues.
- Fix Send Email as HTML default fallback in Email action.
- Fix Save to CSV action headers format when using custom delimiter.

## 1.1.7 (February 22, 2021)

### Forms

- Fix form related PHP warnings.
- Fix Upload element mimetype validation.
- Fix support for multiple forms rendering on the same page.

### Icons

- Fix icon related PHP warnings.
- Fix support for multiple icons declared as HTML in the same field.

## 1.1.6 (February 10, 2021)

- Fix plugin execution time (WordPress).
- Fix support for icons set as HTML.

### Forms

- Fix Fieldset Horizontal Layout display.
- Fix multiple email parsing for Email action.
- Fix Input element attributes rendering.

## 1.1.5 (January 9, 2021)

- Fix MyIcons tab display (WordPress).

## 1.1.4 (December 23, 2020)

- Fix icons Builder integration for pre YOOtheme Pro 2.3.
- Fix issue in admin-selected email attachments in Forms Email action.

## 1.1.3 (November 26, 2020)

- Fix assets loading in multilingual sites (WordPress).
- Fix auto-update issue (WordPress).

## 1.1.2 (November 25, 2020)

- Fix update checking support (WordPress).

### Forms

- Review elements placeholders.
- Review actions settings.
- Review Form Area status evaluation.
- Fix range element php warning on new instances.
- Fix elements control name fallback.
- Fix empty attachments being sent in Email Action.

### Access

- Review rules settings.
- Fix season rule evaluation.
- Fix guest user validation (WordPress).
- Fix Date & Time evaluation if only one value is set.

## 1.1.1 (October 29, 2020)

- Fix Forms Save to CSV action typo causing a php warning.

## 1.1.0 (October 28, 2020)

### Forms

- Add extensions and mimetype HTML validation to Upload field.
- Add delimiter and enclosure params to Save to CSV action.
- Remove required attribute from Range field, as it's natively not supported.
- Remove deprecated Submit element.
- Fix Upload file size validation.
- Fix Upload file overrides when file name collides.

### Access

- Add Browser, Device, Operative System, IP Address, Day, Month, Season and Time rules.
- Change Date rule timezone, is now assumed from the server configuration.

### Icons

- Add icons picker new UI with grouped collections, lazy loading and global search.
- Fix icons rendering on cached articles (Joomla).

### Elements

- Remove file setting from Markdown element in favor of File Source.

## 1.1.0-beta.4 (October 13, 2020)

### Forms

- Add spinner to Submit button.
- Fix validation errors display.
- Fix Radio and Checkbox template rendering issues.

### Icons

- Fix build issue affecting collections.

## 1.1.0-beta.3 (October 7, 2020)

### Forms

- Add text editor for Checkbox and Radio options.
- Fix Input element nodes type.

### Icons

- Add support for icons set as html element `uk-icon` attribute.

## 1.1.0-beta.2 (October 6, 2020)

### Forms

- Add Button element with support for Submit and Reset buttons.
- Add warn if reCaptcha was set more than once in the same Form Area.
- Deprecate Submit element.
- Fix Form Fieldset list of allowed fields.
- Fix Form Input fields missing icon settings.
- Fix Form elements attribute rendering.
- Fix Form reCaptcha validation.
- Fix Form Redirect action.

### Icons

- Fix collections ubication.
- Fix icon loading in modules (Joomla).

## 1.0.2 (October 5, 2020)

### Access

- Fix Language rule (Joomla).

### Icons

- Fix icon loading in footer and modules.

## 1.1.0-beta (October 1, 2020)

- Add Forms Addon 🥳

### Access

- Add URL rule.
- Add Guest option for User Access rule (WordPress).

### Icons

- Add Teenyicons collection.
- Add method to add custom icon collections directories.
- Review core collections.
- Change icons Providers as icons Collections.

### Elements - Social Sharing

- Add Title option.
- Review networks listing.
- Fix custom size.
- Fix custom icon rendering.

### Elements - Charts

- Add Dynamic Content mapping and display options.
- Fix Pie and Doughnut rendering.

## 1.0.1 (September 26, 2020)

- Fix Icons rendering when the field is set on a parent element.

## 1.0.0 (July 22, 2020)

- Add LinkedIn as Social Sharing preset network.

## 1.0.0-beta.7 (July 6, 2020)

- Fix Joomla! install dependency check.

## 1.0.0-beta.6 (July 6, 2020)

- Add Markdown element.
- Add pre install/activate dependencies minimum version check.
- Fix regression introduced in `beta.5` about plugin loading (WordPress).

### Icons

- Fix picker modal performance when listing large amount of items.

## 1.0.0-beta.5 (July 2, 2020)

- Add 1-click update support.
- Add filter by name query for the icons selection Modal.
- Add My Icons tab in icon picker, a collection of icons stored in the current Child Theme.

## 1.0.0-beta.4 (June 26, 2020)

### Access

- Fix current locale for Language rule (WordPress).
- Fix PHP warning when setting fields on some elements edge configurations.

### Icons

- Fix collections support for attributes hard coded in value.

### Elements - Social Sharing

- Add Advanced fields.
- Fix links target.
- Fix WhatsApp link.
- Fix icon consistency for predefined networks.

## 1.0.0-beta.3 (June 23, 2020)

### Access

- Fix Date rule help description and format parsing.

### Icons

- Fix listing regression introduced in `beta.2`.

### Elements

- Add `attributes` field in Advanced settings.
- Fix Chart element data decimals input.

## 1.0.0-beta.2 (June 22, 2020)

### Access

- Add user related rules a Strict option. When enabled the user must have all selected levels for the rule to validate.
- Change Date Access Rule input value to ISO 8601 format: `YYYY-MM-DDThh:mm:ssTZD`.
- Fix Language rule (WordPress).
- Fix User Access rule (WordPress).

### Icons

- Add support for extended Icons in buttons.
- Add support for custom providers.
- Change the nomenclature for 3rd party icon providers from `provider-group:icon-name` to `provider-group--icon-name`.
- Fix icons rendering (WordPress).

### Elements

- Fix mixed charts in Chart Element.
- Change Chart element, Chart Type is now a global option with option to override on each Dataset.

## 1.0.0-beta (June 17, 2020)

- First Release

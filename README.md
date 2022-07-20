# WordPress template

A base template for new dxw WordPress projects, including decision records.

## Using this template

Click "Use this template" to start a new Github repo based on this template, or use `whippet generate app` to generate a repo locally.

Search for `TODO` in this README, and across this repo, and follow those instructions to update it for your new repo, and then delete those instructions.

TODO: Remove the above sections from the README

***

# [Your Project Name]

TODO: Replace the `[Your Project Name]` heading  above with the name of your project.

Production: 
Staging:

TODO: Add the production & staging URLs to the above.

Please use `main`/`develop` branches.

## Project Management

* Trello

TODO: add the link to the Trello board

## Ghost Inspector Tests

* Production
* Staging

TODO: generate default Ghost Inspector test suites for staging p, using GovPress Tools:

```bash
govpress ghostinspector create-suite -s [dalmatian-service-name] -i [dalmatian-infrastructure name -e [dalmatian-environment]
```

Then add the link to this site's Ghost Inspector tests above

## Getting started

Run the setup (first-time run only):

```
script/setup
```

Start the server:

```
script/server
```

You can also run the server in detached mode (i.e. without any output to your console):

```
script/server -d
```

Once the server has started, the following containers will be running:

* WordPress: http://localhost (username/password: `admin`/`admin`)
* MailCatcher: http://localhost:1080
* Beanstalk Console: http://localhost:2080
* MySQL: http://localhost:3306 (username/password: `root`/`foobar`)

For a /bin/sh console running on the WordPress container, run `script/console`
For a MySQL console, run `bin/wp db cli`

## Plugins & Themes

Use [Whippet](https://github.com/dxw/whippet) to manage plugins or external themes.

See the [theme README](wp-content/themes/theme/README.md) for more on how to develop the theme.

TODO: Remove the `README.md` from `wp-content/themes/theme`, and rename `README.example.md` to `README.md`, updating it as needed.

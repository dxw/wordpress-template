# 5. Use this repo as source of setup scripts

Date: 2021-05-28

## Status

Accepted

## Context

Before we created this template repo, we had [WPC](https://github.com/dxw/wpc), a repo which served two main purposes:

* Generating the files necessary within a Whippet-based WordPress app for local development in Docker, using the "scripts to rule them all" model. This meant e.g. generating the `docker-compose.yml` file, and the relevant files for the script folder (e.g. `script/setup`, `script/server`, etc.)
* Acting as a source for the `thedxw/wpc-wordpress` docker image we use for running WordPress in docker in local development environments

Now we have this template repo, which also contains all files necessary for running a docker-based development environment (but not the `wpc-wordpress` docker image itself). We shouldn't duplicate those files in two separate repos.

We no longer have the need to generate those files within existing projects, as all existing Whippet apps have already been converted for docker-based development. New projects (or projects we  inherit, e.g. old Helpful repos) will use this template repo to provide that infrastructure.

## Decision

Use this repository as the primary source for the files that were previously generated by WPC. 

Remove those files from the [WPC repo](https://github.com/dxw/wpc), so that repo is only responsible for the `wpc-wordpress` docker image, and nothing else.

## Consequences

We only have one place to maintain the "scripts to rule them all" files, and any other files we use to support the local development environment. There is no confusion about what the primary source for those files is.

WPC has a single responsibility: acting as the source for our `wpc-wordpress` docker image.

If in future we have a need to generate/update these files across multiple repos, we may have to build a new tool to meet that need as and when it arises. 

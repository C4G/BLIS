# Testing Deployments

After you are satisfied with your new changes and want to deploy a newer version BLIS on cloud. In this doc, we will use [DigitalOcean](https://www.digitalocean.com/) for the deployment platform as example. You will go through two main steps:

1. Push & merge your changes to github repo. Based on `./github/workflows/release-docker.yml`, the newest change will reflect in the `ghcr.io/C4G/blis:latest` docker repo.
2. Use the docker image to deploy BLIS service as well as database service. An step-by-step detailed instruction can be seen [in this site](../user_guide/11_blis_cloud.md)

<!-- TODO, change the workflow file hyperlink after merging into the main -->

### Deployment Video

Video showing how to deploy the BLIS cloud version, upgrade script and collected survey from the BLIS online team in Spring of 2023

[![BLIS DEPLOYMENT](https://i.ytimg.com/vi/mQFPkyUIiXg/maxresdefault.jpg)](https://www.youtube.com/watch?v=mQFPkyUIiXg)

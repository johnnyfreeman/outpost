# bilbo

A command runner thingy affectionately called Bilbo.

## Web

![image](https://github.com/johnnyfreeman/bilbo/assets/371481/9ba59596-b6db-4a71-88d6-1f45ce2d2dae)

The web interface is where pipelines and jobs are created.

## Api

The api can be explored using [Bruno](https://www.usebruno.com/) and our [Bruno collection](/bruno).

## Agent

![image](https://github.com/johnnyfreeman/bilbo/assets/371481/2fecedca-dc77-4d98-ada1-eaccd77a6bf9)

The agent will poll the API for jobs. To start an agent, it needs an `AGENT_ID` and an `API_HOST`. If these environment variables are not detected, you will be prompted for them.

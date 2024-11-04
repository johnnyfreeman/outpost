# Outpost

A simple, remote agent to make CI/CD a breeze.

## Web Interface

![Web Interface](https://github.com/johnnyfreeman/bilbo/assets/371481/9ba59596-b6db-4a71-88d6-1f45ce2d2dae)

The web interface is where you can easily set up and manage your pipelines and jobs. It’s a one-stop shop for designing workflows and scheduling commands to run on your servers.

## API

Play around with the Outpost API using [Bruno](https://www.usebruno.com/) and our [Bruno collection](/bruno). It’s a handy way to test things out and connect with your CI/CD setup.

## Agent

![Agent](https://github.com/johnnyfreeman/bilbo/assets/371481/2fecedca-dc77-4d98-ada1-eaccd77a6bf9)

The Outpost agent keeps an eye on the API and runs jobs as they come in. To get the agent going, just set `AGENT_ID` and `API_HOST` as environment variables. If you forget, no worries—it'll prompt you for them.

## Alternative

If you just need to run commands over SSH, check out [Foundry](https://github.com/johnnyfreeman/foundry). It’s a lightweight CLI tool built for direct, idempotent server setup and management.

Keep things simple, stay connected, and let Outpost handle the heavy lifting for your CI/CD needs.


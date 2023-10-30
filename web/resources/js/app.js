import './bootstrap';

import { Application } from "@hotwired/stimulus"
import { registerControllers } from "stimulus-vite-helpers"
import * as Turbo from "@hotwired/turbo"

Turbo.setProgressBarDelay(250)

const application = Application.start()
const controllers = import.meta.globEager("./controllers/*-controller.js")
registerControllers(application, controllers)
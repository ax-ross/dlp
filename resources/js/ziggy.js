const Ziggy = {"url":"http:\/\/127.0.0.1","port":null,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"auth":{"uri":"auth","methods":["GET","HEAD"]},"register.show":{"uri":"auth\/register","methods":["GET","HEAD"]},"register.store":{"uri":"auth\/register","methods":["POST"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"teacher.dashboard":{"uri":"teacher\/dashboard","methods":["GET","HEAD"]},"teacher.invitation.create":{"uri":"teacher\/invitations","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.rotes, window.Ziggy.routes);
}

export { Ziggy };

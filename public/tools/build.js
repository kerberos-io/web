{
    baseUrl: '../js/',
    appDir: '',
    mainConfigFile: '../js/main.js',
    dir: '../js-built',
    modules: [
        {
            name: "main",
            include: ["jquery"]
        },
        {
            name: "app/controllers/dashboard",
            exclude: ["main"]
        },
        {
            name: "app/controllers/hullselection",
            exclude: ["main"]
        },
        {
            name: "app/controllers/images",
            exclude: ["main"]
        }
    ]
}
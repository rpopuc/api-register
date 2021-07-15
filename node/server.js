var express = require("express");
var newmanTest = require('./tester');
var app = express();

app.get("/test/:provider/:consumer", (req, res, next) => {
    res.header('content-type', 'application/json;charset=UTF-8')
    res.status(200)

    newmanTest(req.params.provider, req.params.consumer)
        .then(summary => {
            res.write(
                JSON.stringify(summary, 0, 4)
            )

            res.end()
        })
        .catch(err => {
            res.write(
                JSON.stringify(err, 0, 4)
            )

            res.end()
        })
});

app.listen(3000, () => {
    console.log("Server running on port 3000");
});
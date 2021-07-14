var express = require("express");
var newman = require('newman');
var app = express();

app.listen(3000, () => {
    console.log("Server running on port 3000");
});

const makeReport = (summary) => {
    var result = {}
    var failures = []

    summary.run.failures.forEach(function(failure) {
        failures.push({
            'Parent': {
                'Name': failure.parent.name,
                'Id' : failure.parent.id
            },
            'Source': {
                'Name': failure.source.name,
                'Id' : failure.source.id
            },
            'Error': {
                'Message': failure.error.message,
                'Test' : failure.error.test
            }
        })
    })

    Object.assign(result, {
        'Collection': {
            'Info': {
                'Name': summary.collection.name,
                'Id': summary.collection.id
            }
        },
        'Run': {
            'Stats': {
                "Requests" : summary.run.stats.requests,
                "Assertions" : summary.run.stats.assertions
            },
            'Failures': failures,
            'Timings' : summary.run.timings
        }
    })

    return JSON.stringify(result, null, 2)
}

app.get("/test/:provider/:consumer", (req, res, next) => {
    res.header('content-type', 'application/json;charset=UTF-8')
    res.status(200);

    const result = newman.run({
        envVar: [
            {
                key: 'url',
                value: "http://app/api/v1/mock"
            }
        ],
        collection: `http://app/api/v1/providers/${req.params.provider}/consumers/${req.params.consumer}.json`
    }, (err, summary) => {
        if (err) { throw err }

        res.write(
            makeReport(summary)
        )

        res.end()
    });

});

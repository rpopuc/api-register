module.exports = function (summary) {
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

    return result
}
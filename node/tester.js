const newman = require('newman')
const makeReport = require('./report')

module.exports = function(provider, consumer) {
    return new Promise((resolve, reject) => {
        newman.run({
            envVar: [
                {
                    key: 'url',
                    value: "http://localhost/api/v1/mock"
                }
            ],
            collection: `http://localhost/api/v1/providers/${provider}/consumers/${consumer}.json`
        }, (err, summary) => {
            if (err) {
                reject(err)
                return
            }

            resolve(makeReport(summary))
        });
    })
}

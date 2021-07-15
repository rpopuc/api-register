const newmanTest = require('./tester')

const args = process.argv.slice(2)
const provider = args[0]
const consumer = args[1]

newmanTest(provider, consumer)
    .then(summary => {
        console.log(JSON.stringify(summary, null, 4))
    })
    .catch(err => {
        console.log('Deu ruim')
    })
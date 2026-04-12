//Import required modules
const fs = require('fs'); // File system module for writing logs
const path = require('path'); // Path module for file paths
const { format } = require('date-fns'); // Date formatting library



//Function to catch errors in the Express app to logs them and send a response
const errorHandler = async (err, req, res, next) => {

  //Format the current timestamp
    const timestamp = format(new Date(), 'yyyy-MM-dd HH:mm:ss');



  //Create the error log entry with details
    const errorLog = `
        [${timestamp}] Error Name: ${err.name}
        Message: ${err.message}
        Route: ${req.method} ${req.originalUrl}
        Status: ${err.status || 500}
        Stack: ${err.stack || 'No stack available'}
        `;

    //Try to write the error log to file
    try {
        //Define logs directory path
        const logDir = path.join(__dirname, '..', 'logs');

        //Create logs directory if it doesn't exist
        if (!fs.existsSync(logDir)) {
        fs.mkdirSync(logDir, { recursive: true });
        }

        //Append the error log to errorLog.txt
        await fs.promises.appendFile(path.join(logDir, 'errorLog.txt'), errorLog);
    } catch (writeError) {
        //Log errors that occur while writing the log file
        console.error('Error writing error log:', writeError);
    }

    //If headers already sent, pass the error to next handler
    if (res.headersSent) {
        return next(err);
    }

    //Send JSON error response to client
    res.status(err.status || 500).json({
        error: {
        message: err.message || 'Internal Server Error',
        status: err.status || 500,
        },
    });
};

//Export middleware
module.exports = errorHandler;

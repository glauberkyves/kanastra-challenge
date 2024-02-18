const { SQSClient, SendMessageCommand, DeleteMessageCommand } = require("@aws-sdk/client-sqs");
const sqs = new SQSClient();

const producer = async (event) => {
  let statusCode = 200;
  let message;

  if (!event.body) {
    return {
      statusCode: 400,
      body: JSON.stringify({
        message: "No body was found",
      }),
    };
  }

  try {
    await sqs.send(new SendMessageCommand({
      QueueUrl: process.env.QUEUE_URL,
      MessageBody: event.body,
      MessageAttributes: {
        AttributeName: {
          StringValue: "Attribute Value",
          DataType: "String",
        },
      },
    }));

    message = "Message accepted!";
  } catch (error) {
    console.log(error);
    message = error;
    statusCode = 500;
  }

  return {
    statusCode,
    body: JSON.stringify({
      message,
    }),
  };
};

const consumer = async (event) => {
  try {
    for (const record of event.Records) {
      console.log(JSON.stringify(record), 'params record')

      const params = JSON.parse(record.body)
      await axios.post(`${process.env.URL}/api/invoices/batch`, params)

      const deleteParams = {
        QueueUrl: process.env.QUEUE_URL,
        ReceiptHandle: record.receiptHandle
      }

      await sqs.send(new DeleteMessageCommand(deleteParams))
    }

  } catch (error) {
    console.error('Erro geral:', error)

  } finally {
  }

  return {statusCode: 200, body: JSON.stringify({error: 'ok'})}
};

module.exports = {
  producer,
  consumer,
};

use PhpMqtt\Client\Facades\MQTT;

MQTT::publish('some/topic', 'Hello World!');

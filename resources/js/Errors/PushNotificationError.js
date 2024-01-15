export default class PushNotificationError extends Error {
    constructor(message) {
        super(message);
        this.name = "PushNotificationError";
    }
}

import telethon
from telethon.sync import TelegramClient
from telethon import Button
import requests

# Your Telegram API credentials
api_id = '20997505'
api_hash = '607fc789f3c2d041a51b0a3e3227c410'

user = '+85585773007'  # Replace with the recipient's phone number in international format
message = 'Hello, Sending you bear hugs and sunshine'  # Your message
image_path = 'https://telegram-bot-sdk.com/img/telegram-bot-sdk-commands-handler.png'
# Create a Telegram client
client = TelegramClient('session_name', api_id, api_hash)

async def main():
    await client.start()

    markup = client.build_reply_markup(Button.inline('hi'))

    # Send a message with the inline keyboard
    msg = await client.send_message(entity=user, message=message, buttons=markup)
    msg = await client.send_file(user, image_path, caption='Hello from your Telegram bot!')


    all_contacts = []

    async for dialog in client.iter_dialogs():
        if dialog.is_user and not dialog.entity.bot:
            all_contacts.append(dialog.entity)

    return all_contacts

# Run the script
with client:
    all_contacts = client.loop.run_until_complete(main())
    print(all_contacts)


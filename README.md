# SIIT-CSS326-AI-Chatbot

A web-based AI chatbot application built with PHP and MySQL, featuring user authentication, chat sessions, and integration with Hugging Face's BlenderBot model for conversational AI.

## Features

- User authentication (login/signup)
- Multi-session chat management
- AI-powered responses using Facebook's BlenderBot-400M-Distill
- Dark/Light theme toggle
- Multi-language support (Thai/English)
- Message feedback system (upvote/downvote)
- Save and archive chat messages
- User profile management
- Soft delete with restoration capability

## Tech Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, Bootstrap 5.3
- **JavaScript**: Vanilla JS, Bootstrap Bundle
- **AI Model**: Facebook BlenderBot-400M-Distill via Hugging Face API

## Prerequisites

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Hugging Face API token

## Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/SIIT-CSS326-AI-Chatbot.git
cd SIIT-CSS326-AI-Chatbot
```

2. Create the database
```bash
mysql -u root -p < chatbot_db.sql
```

3. Configure database connection
```bash
cp db.example.php db.php
```
Edit `db.php` with your database credentials:
```php
$host = 'localhost';
$db   = 'chatbot_db';
$user = 'your_username';
$pass = 'your_password';
```

4. Configure Hugging Face API
- Get your API token from [Hugging Face](https://huggingface.co/settings/tokens)
- Update the API token in `bot.php` (line 22)

5. Set up your web server
- Point your web server's document root to the project directory
- Ensure the directory has proper write permissions

6. Access the application
- Open your browser and navigate to `http://localhost/` (or your configured domain)

## Project Structure

```
SIIT-CSS326-AI-Chatbot/
├── archive.php          # View archived messages
├── bot.php              # AI bot logic and API integration
├── bot_icon.png         # Bot avatar image
├── chat.php             # Main chat interface
├── chat_style.css       # Chat page styles
├── chat_test.php        # Testing page
├── chatbot_db.sql       # Database schema and initial data
├── db.php               # Database connection (not tracked)
├── db.example.php       # Database connection template
├── delete.php           # Account deletion
├── edit.php             # Profile editing
├── help.php             # Help/command reference
├── index.php            # Landing page
├── login.php            # User login
├── model.php            # Model information display
├── register.php         # User registration
├── restore_user.php     # Restore deleted account
├── setting.php          # User settings
├── sign_up.php          # Sign up page
├── themeHandler.js      # Theme switching logic
├── user_icon.png        # User avatar image
└── user_setting.css     # User settings styles
```

## Database Schema

### Tables
- **users**: User accounts and profile information
- **sessions**: Chat sessions linked to users
- **messages**: Individual messages in sessions
- **modelmetadata**: AI model information
- **modelfeedback**: User feedback on bot responses

### Key Features
- Foreign key constraints for data integrity
- Soft delete with `deleted_at` timestamp
- Views for aggregated data (model_feedback_summary, saved_bot_messages, usersessionmessages)
- Stored procedures for soft delete and restore operations
- Triggers for automatic timestamp updates
- Scheduled event for permanent deletion of soft-deleted records (30 days)

## Chat Commands

| Command | Description |
|---------|-------------|
| `/help` | Display help information |
| `/model` | View model information |
| `/delete` | Delete current chat session |
| `/name <new_name>` | Rename current session |
| `/save` | Save the latest bot message |
| `/archive` | View archived messages |
| `/upvote [comment]` | Upvote latest bot response |
| `/downvote [comment]` | Downvote latest bot response |

## Security Features

- Password hashing using PHP's `password_hash()`
- Prepared SQL statements to prevent SQL injection
- Session-based authentication
- Input sanitization with `htmlspecialchars()`
- XSS protection
- CSRF considerations (form-based submissions)

## API Integration

The application uses the Hugging Face Inference API to interact with Facebook's BlenderBot model:

- **Model**: facebook/blenderbot-400M-distill
- **Endpoint**: https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill
- **Authentication**: Bearer token

## Screenshots

*Landing Page*: Animated text display with login/signup options
*Chat Interface*: Split-view with session list and chat area
*Settings Page*: User profile and preferences management

## Browser Support

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Mobile browsers (responsive design)

## Known Issues

1. API rate limits may affect response times
2. SSL certificate verification disabled in cURL (for development only)
3. Model responses may occasionally be irrelevant or unexpected

## Future Improvements

- [ ] Add conversation context retention
- [ ] Implement real-time messaging with WebSockets
- [ ] Add file/image sharing capability
- [ ] Implement multiple AI model support
- [ ] Add email verification
- [ ] Implement password reset
- [ ] Add two-factor authentication
- [ ] Improve mobile responsiveness
- [ ] Add message search functionality
- [ ] Implement chat export feature

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is created for educational purposes as part of SIIT CSS326 coursework.

## Acknowledgments

- Facebook AI for BlenderBot
- Hugging Face for the Inference API
- Bootstrap team for the UI framework
- SIIT for the course project opportunity

## Contact

Project Link: [https://github.com/yourusername/SIIT-CSS326-AI-Chatbot](https://github.com/yourusername/SIIT-CSS326-AI-Chatbot)

## Changelog

### Version 1.0.0
- Initial release
- User authentication system
- Chat functionality with AI integration
- Dark mode support
- Multi-language support
- Message feedback system
- Archive and restore features

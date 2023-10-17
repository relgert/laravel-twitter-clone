# Laravel-Vue.js Twitter Clone


## Live demo

http://twitter.giovanni-elgert.info

        mail: vince.terry@gmail.com
        password: password


## Overview

I embarked on creating a Twitter clone using Laravel and Vue.js, driven by its familiarity and robust feature set. This project provided a real-world application to practice essential web development concepts, while also allowing room for creative innovation. The result is a showcase of my proficiency in building user-centric web applications.

## Why a Twitter clone?

#### Familiarity and User-Centered Design:

Twitter is a globally recognized platform, ensuring that users are already familiar with its functionality. By replicating its core features, I aimed to leverage this familiarity to create an intuitive and user-friendly experience.
#### Feature-Rich Learning Environment:

Twitter boasts a wide array of functionalities, providing an excellent playground to practice various concepts in Laravel and Vue.js. This allowed me to delve into user authentication, real-time interactions, and data management, all of which are crucial aspects of web development.

#### Abundant Learning Opportunities:

Building a Twitter-like application required me to master common web development concepts such as authentication, authorization, database interactions, and UI/UX design. This project served as an invaluable learning ground for honing these fundamental skills in laravel and vue.js


## Features

- User authentication and authorization
- Tweet creation, deletion, and viewing
- Tweet Retweet, Quote and Reply
- Image uploads with previews
- Follow/unfollow other users
- Favorite and unfavorite tweets
- User profiles with bio, stats and avatar
- Notifiacations
- Virtual list for infinite scroll with dynamic heights
- CI/CD With Github actions
- Unit Tests

### Some Laravel Concepts Applied

- Authentication
- Queues
- Broadcast
- Events
- Listeners
- Observers
- Pagination
- Validation
- Redis
- Horizon
- Database Seeding
- Database Migration
- Eloquent Query building
- Eloquent Relations
- Eloquent Factories
- Eloquent Collections
- File Storage
- Testing

### Some Vue.js Concepts Applied

- Pinia store
- Higher Order Components (HOC)
- Reusable Virtual list with dynamic heights tested: 10k items with images
- Reusable Modal

## Installation

1. Clone the repository:

```bash
git clone https://github.com/relgert/laravel-twitter-clone.git
```

2. Navigate to the project directory:

```bash
cd laravel-twitter-clone
```

3. Install dependencies:

```bash
composer install
npm install && npm run dev
```

4. Copy the `.env.example` file to `.env` and configure your environment variables, including database connection details and pusher credentials

--

5. Generate a new application key:

```bash
php artisan key:generate
```

6. Migrate and seed the database:

```bash
php artisan migrate --seed
```

7. Serve the application:

```bash
php artisan serve
```

8. Visit `http://localhost:8000` in your web browser and login using any user on the database, all generated passwords are **'password'**.

## Usage

- Log in with existing credentials.  

        mail: vince.terry@gmail.com  
        password: password  

- Start posting tweets, following other users, and engaging with the community.

## Contributing

If you'd like to contribute, please fork the repository and then create a pull request with your changes. Make sure to follow the [contributing guidelines](CONTRIBUTING.md).

## License

This project is licensed under the [MIT License](LICENSE).

## Acknowledgements

- Special thanks to [Laravel](https://laravel.com/) for providing an excellent PHP framework.
- Shoutout to the open-source community for their continuous contributions.

## Contact

For questions or feedback, feel free to contact the project owner:

- Name: Giovanni Elgert
- Email: giovanni.elgert@gmail.com



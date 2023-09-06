FROM relgert/laravelbase

# Create system user to run Composer and Artisan Commands
# RUN useradd -G www-data,root -u $uid -d /home/$user $user
# RUN mkdir -p /home/$user/.composer && \
#     mkdir -p /home/$user/.npm && \
#     chown -R $user:$user /home/$user


# Set working directory
WORKDIR /var/www



#COPY . .



#RUN rm -rf ./vendor
#RUN rm -rf ./composer.lock



# RUN chown -R www-data:www-data /var/www/storage
# RUN chmod -R 777 /var/www/storage



#RUN composer install

#RUN npm install

#RUN npm run build


COPY .env.docker /var/www/.env

#RUN php artisan cache:clear

#RUN chown -R $user:$user /var/www

#USER $user




# CRA
#dckr_pat_ydhE6H4vZUWzleFTA3N8sZ7NYoo


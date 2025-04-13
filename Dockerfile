FROM php:8.1-cli

# Cài các extensions nếu cần
RUN docker-php-ext-install pdo pdo_mysql

# Copy toàn bộ project vào container
COPY . /var/www/html

# Đặt thư mục làm working dir
WORKDIR /var/www/html

# Mở port 8080 để Railway truy cập
EXPOSE 8080

# Chạy PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]

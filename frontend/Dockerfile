# Use official Node.js image
FROM node:18

# Set working directory inside the container
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json yarn.lock ./
RUN yarn install

# Copy all files to container
COPY . .

# Expose port for React app
EXPOSE 3000

# Start the React development server
CMD ["yarn", "start"]

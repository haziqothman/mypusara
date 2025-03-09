FROM node:alpine AS build
WORKDIR /frontend
COPY package.json ./
RUN npm i
COPY . .
RUN npm run build

FROM nginx:alpine
COPY --from=build /frontend/build /usr/share/nginx/html

# Expose port 80 for the Nginx server
EXPOSE 80

# Start Nginx when the container runs
CMD ["nginx", "-g", "daemon off;"]

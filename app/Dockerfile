FROM tiangolo/node-frontend:10 as build-stage
WORKDIR /app/
COPY ./* /app/
COPY package-lock.json /app/
RUN npm install
RUN npm start
FROM nginx:1.15
COPY --from=build-stage /app/build/ /usr/share/nginx/html
COPY ./nginx.conf /etc/nginx/conf.d/default.conf
FROM tiangolo/node-frontend:10 as build-stage
WORKDIR /app
COPY package-*.json /app/
RUN npm install
COPY ./ /app/
RUN npm run build
EXPOSE 80



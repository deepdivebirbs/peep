FROM tiangolo/node-frontend:10 as build-stage
WORKDIR /app
COPY package.json /app/
RUN npm install
COPY ./ /app/
EXPOSE 80
CMD ["npm", "run", "start"]



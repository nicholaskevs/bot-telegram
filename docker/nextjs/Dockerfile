FROM node:26.1-alpine

WORKDIR /app

COPY nextjs/package.json nextjs/package-lock.json ./
RUN npm ci

COPY nextjs/ ./

EXPOSE 3000

CMD ["npm", "run", "dev", "--", "--hostname", "0.0.0.0", "--port", "3000"]

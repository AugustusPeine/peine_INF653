# Deployment Guide - Render.com

Complete guide to deploy your Event Ticketing System API to Render.com for free.

## Prerequisites

- GitHub account with your project pushed
- Render.com account (free)
- MongoDB Atlas account with connection string

## Step 1: Prepare GitHub Repository

### 1.1: Create GitHub Repository

1. Go to [GitHub.com](https://github.com)
2. Click "New" to create a new repository
3. Name it: `event-ticketing-api`
4. Description: "Event Ticketing System REST API"
5. Choose "Public" or "Private"
6. Click "Create repository"

### 1.2: Push Your Code

```bash
# Initialize git (if not already done)
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit: Event Ticketing API"

# Add remote (replace YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/event-ticketing-api.git

# Push to GitHub
git branch -M main
git push -u origin main
```

### 1.3: Verify .env.example is Committed

```bash
# Make sure .gitignore has .env (but not .env.example)
git status

# .env should NOT appear in the list
# .env.example SHOULD appear in the list
```

## Step 2: Create Render Account

1. Go to [render.com](https://render.com)
2. Click "Sign up"
3. Choose "Sign up with GitHub" (easiest)
4. Authorize Render to access GitHub
5. Verify email

## Step 3: Deploy the Web Service

### 3.1: Create New Service

1. Go to Render Dashboard
2. Click "New +"
3. Select "Web Service"
4. Click "Connect a repository"

### 3.2: Select Repository

1. Choose your GitHub account
2. Search for `event-ticketing-api`
3. Click "Connect" next to the repository

### 3.3: Configure the Service

Fill in the following:

**Name:**
```
event-ticketing-api
```

**Environment:**
```
Node
```

**Region:**
```
Choose closest to your location (e.g., US, EU, etc.)
```

**Branch:**
```
main
```

**Build Command:**
```
npm install
```

**Start Command:**
```
npm start
```

### 3.4: Add Environment Variables

Click "Advanced" to expand options, then click "Add Environment Variable" for each:

| Key | Value |
|-----|-------|
| `MONGODB_URI` | `mongodb+srv://username:password@cluster.mongodb.net/event-ticketing` |
| `JWT_SECRET` | Generate a random string (use generator or paste here) |
| `JWT_EXPIRE` | `7d` |
| `PORT` | `3000` (Render assigns its own) |

**Important:** 
- Get your MONGODB_URI from MongoDB Atlas
- Use a strong JWT_SECRET (example: `your_super_secret_jwt_key_12345_change_this_in_production`)

### 3.5: Plan and Deploy

1. **Plan:** Free tier (you'll get limited resources, but it's free)
2. Click "Create Web Service"

The deployment will start automatically!

## Step 4: Monitor Deployment

1. You'll be taken to the service page
2. Watch the logs as it deploys
3. It may take 3-5 minutes

You should see:
```
MongoDB Connected: cluster0.xxxxx.mongodb.net
Server running on port 3000
```

## Step 5: Find Your Deployed URL

1. Look at the top of the Render dashboard
2. Your URL will be something like:
```
https://event-ticketing-api-XXXX.onrender.com
```

3. Test it:
```bash
curl https://event-ticketing-api-XXXX.onrender.com/
```

You should see the welcome HTML page.

## Step 6: Update Root Route (Optional)

For the project requirements, you may want your root URL to display a welcome page:

1. Your root URL is: `https://event-ticketing-api-XXXX.onrender.com/`
2. Your API is at: `https://event-ticketing-api-XXXX.onrender.com/api/`

The `server.js` already handles this! ✅

## Step 7: Test Your Deployed API

### Test Root URL
```bash
curl https://event-ticketing-api-XXXX.onrender.com/
```
Should return HTML welcome page.

### Test API Root
```bash
curl https://event-ticketing-api-XXXX.onrender.com/api/
```
Should return API documentation.

### Test Auth Endpoint
```bash
curl -X POST https://event-ticketing-api-XXXX.onrender.com/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@example.com","password":"password123"}'
```

### Test Events Endpoint
```bash
curl https://event-ticketing-api-XXXX.onrender.com/api/events
```

## Step 8: Enable Auto-Deploy (Recommended)

1. Go to your Render service
2. Click "Settings"
3. Scroll down to "Auto-Deploy"
4. Select "Yes" for auto-deploy on every push to main

Now every time you push to GitHub, Render will automatically redeploy!

## Updating Your Deployed App

To update your deployed app after making changes:

```bash
# Make your changes locally
# Test them

# Add and commit
git add .
git commit -m "Update: description of changes"

# Push to GitHub
git push

# Render will automatically redeploy!
```

## Troubleshooting

### App keeps restarting

Usually means there's an error. Check the logs:
1. Go to your service on Render
2. Click "Logs"
3. Look for error messages
4. Common issues:
   - MongoDB connection failed (check MONGODB_URI)
   - JWT_SECRET missing (add to environment variables)
   - Dependency not installed (add to package.json)

### "Cannot GET /"

The root route might not be loading. Check:
1. server.js has root route defined ✓
2. Check logs for startup errors

### "MongoDB connection error"

1. Check MONGODB_URI in Render environment variables
2. Verify MongoDB Atlas cluster is active
3. In MongoDB Atlas, go to Network Access
4. Add IP 0.0.0.0/0 to allow all connections (temporary, for testing)

### "Port issue"

Render assigns ports automatically. Don't hardcode port 5000.
The code already handles this with: `const PORT = process.env.PORT || 5000` ✓

## Important Notes

⚠️ **For Production:**

1. **Change JWT_SECRET**
   - Generate a strong random string
   - Never use the example secret in production

2. **MongoDB Atlas Security**
   - Create a dedicated MongoDB user for your app
   - Use a strong password
   - Limit IP access if possible
   - Enable encryption at rest

3. **Monitor Costs**
   - Render free tier has limitations
   - Monitor MongoDB Atlas usage
   - Set up alerts

4. **Backups**
   - Enable MongoDB automatic backups
   - Regularly export important data

## Free Tier Limitations

**Render Free Tier:**
- 0.5 GB RAM
- 0.5 CPU
- Auto-sleeps after 15 minutes of inactivity (spins up on request)
- For testing/learning only

**For Production:**
- Upgrade to Paid plan
- Or use: Heroku, Railway, Cyclic, Glitch

## Free MongoDB Atlas:**

- 512 MB storage (plenty for testing)
- Free forever (for learning)
- Good for projects under 512 MB of data

## Next Steps

1. ✅ Deploy your API
2. ✅ Test all endpoints
3. ✅ Build a frontend to consume the API
4. ✅ Add custom domain (if upgrading)
5. ✅ Set up monitoring and alerts

## Support

If deployment fails:
1. Check the Render logs
2. Verify all environment variables
3. Ensure MongoDB connection works locally first
4. Check GitHub repository is public (or Render has access)

## Useful Commands

```bash
# Check git remote
git remote -v

# View deployment logs
# (Only through Render dashboard)

# Redeploy manually
# Click "Manual Deploy" button in Render dashboard

# Rollback to previous deploy
# Click "Previous Deploys" in Render dashboard
```

Happy deploying! 🚀

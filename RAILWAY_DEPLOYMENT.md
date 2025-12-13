# Railway Deployment Guide - Word Tracker Backend

## ✅ Production-Ready Features Implemented

### 1. **Stable Database Connection**
- Connection pooling with configurable limits
- Keep-alive enabled for persistent connections
- Automatic reconnection handling
- Connection verification on startup

### 2. **Safe Schema Migration**
- Schema runs automatically on deployment
- Uses `IF NOT EXISTS` to prevent crashes on redeploy
- Retry logic with exponential backoff (5 attempts)
- Safe for multiple deployments without data loss

### 3. **Error Handling & Logging**
- Structured logging with `[INFO]`, `[SUCCESS]`, `[ERROR]`, `[FATAL]` prefixes
- Global handlers for unhandled rejections and uncaught exceptions
- Graceful shutdown on SIGTERM/SIGINT
- Clean error messages for debugging

### 4. **CORS Configuration**
- Full CORS support for Netlify frontend
- Supports all common HTTP methods (GET, POST, PUT, DELETE, PATCH)
- Preflight request handling
- Custom headers support (Authorization, X-Requested-With)

### 5. **Health Monitoring**
- `/health` endpoint for Railway health checks
- `/status` endpoint (alias for health)
- Database connectivity verification
- Uptime and timestamp reporting

### 6. **Production Optimizations**
- Retry logic for database operations
- Exponential backoff for failed connections
- Automatic restart on failure (Railway config)
- Binds to `0.0.0.0` for Railway compatibility

---

## 📁 Files Deployed

```
word-tracker-main/
├── server.js              # Main application server
├── package.json           # Node.js dependencies
├── package-lock.json      # Locked dependency versions
├── railway.json           # Railway deployment config
└── .railwayignore         # Excludes frontend/PHP from deployment
```

---

## 🚀 Railway Deployment Steps

### **Step 1: Verify Git Push**
Your code has been pushed to GitHub. Railway will auto-deploy if connected.

```bash
✅ Committed: "Production-ready Node.js backend with retry logic, enhanced error handling, and Railway config"
✅ Pushed to: origin/main
```

### **Step 2: Railway Configuration**

The `railway.json` file configures:
- **Builder**: Nixpacks (automatic detection)
- **Start Command**: `node server.js`
- **Restart Policy**: Automatic restart on failure (max 10 retries)

### **Step 3: Environment Variables**

Railway should automatically detect the MySQL service. If not, verify these variables exist:
- `MYSQLHOST`
- `MYSQLPORT`
- `MYSQLUSER`
- `MYSQLPASSWORD`
- `MYSQLDATABASE`

**Note**: The code uses hardcoded credentials as requested. No env vars needed for DB connection.

### **Step 4: Monitor Deployment**

Watch Railway logs for these success messages:
```
[INFO] Starting Word Tracker Backend...
[INFO] Node version: v18.x.x
[INFO] Attempting database schema initialization (attempt 1/5)...
[SUCCESS] Database schema executed successfully.
[INFO] Creating database connection pool...
[INFO] Verifying database connection (attempt 1/5)...
[SUCCESS] Database connection verified.
[SUCCESS] Server running on port 3000
[INFO] Health check available at: http://0.0.0.0:3000/health
```

### **Step 5: Test Endpoints**

Once deployed, test these endpoints:

#### **Health Check**
```bash
curl https://your-railway-app.railway.app/health
```

Expected response:
```json
{
  "status": "healthy",
  "uptime": 123.456,
  "timestamp": "2025-12-13T00:00:00.000Z",
  "database": "connected"
}
```

#### **Root Endpoint**
```bash
curl https://your-railway-app.railway.app/
```

Expected response:
```json
{
  "message": "Word Tracker API",
  "version": "1.0.0",
  "status": "running"
}
```

---

## 🔧 Troubleshooting

### **Issue: Database Connection Fails**
**Solution**: Check Railway logs for connection errors. Verify MySQL service is running.

### **Issue: Schema Errors on Redeploy**
**Solution**: The code uses `IF NOT EXISTS` - tables won't be recreated. Safe to redeploy.

### **Issue: Port Binding Error**
**Solution**: Railway sets `PORT` env var automatically. Server binds to `0.0.0.0:$PORT`.

### **Issue: CORS Errors from Frontend**
**Solution**: CORS is configured for `*` origin. Check frontend is making requests to correct URL.

---

## 📊 Database Schema

The following tables are created automatically:
- `users` - User accounts
- `plans` - User plans/goals
- `plan_days` - Daily plan tracking
- `checklists` - User checklists
- `checklist_items` - Checklist items

All tables use `IF NOT EXISTS` for safe redeployment.

---

## 🔐 Security Notes

- Credentials are hardcoded as requested (will be moved to env vars later)
- CORS allows all origins (`*`) - restrict in production if needed
- Database uses Railway's private network for security
- Connection pooling prevents connection exhaustion

---

## 📈 Next Steps

1. ✅ **Verify Railway deployment logs**
2. ✅ **Test health endpoint**
3. ✅ **Update Netlify frontend with Railway backend URL**
4. ✅ **Monitor application performance**
5. 🔜 **Add API endpoints for frontend integration**

---

## 🆘 Support

If deployment fails:
1. Check Railway build logs
2. Verify MySQL service is running
3. Check environment variables
4. Review server logs for error messages

---

**Deployment Status**: ✅ Ready for Production
**Last Updated**: 2025-12-13
**Version**: 1.0.0

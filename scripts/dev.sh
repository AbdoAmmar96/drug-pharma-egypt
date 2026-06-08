#!/usr/bin/env bash
# Start both Laravel backend (port 8000) and React frontend (port 5173)
# in parallel. Ctrl+C stops both cleanly.
#
# Usage:  ./scripts/dev.sh

set -e
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
LOG_DIR="$ROOT/.deploy-cache/logs"
mkdir -p "$LOG_DIR"

# Free the ports if something's stuck on them
for port in 8000 5173; do
  pid=$(lsof -ti tcp:$port 2>/dev/null || true)
  [ -n "$pid" ] && { echo "▸ Killing leftover process on port $port (pid $pid)"; kill -9 $pid 2>/dev/null || true; }
done

echo "▸ Starting Laravel on http://localhost:8000 ..."
(cd "$ROOT/backend" && php artisan serve > "$LOG_DIR/backend.log" 2>&1) &
BACKEND_PID=$!

echo "▸ Starting Vite on   http://localhost:5173 ..."
(cd "$ROOT/frontend" && npm run dev > "$LOG_DIR/frontend.log" 2>&1) &
FRONTEND_PID=$!

cleanup() {
  echo
  echo "▸ Shutting down..."
  kill $BACKEND_PID $FRONTEND_PID 2>/dev/null || true
  wait 2>/dev/null
  exit 0
}
trap cleanup INT TERM

# Wait a moment then show URLs
sleep 3
echo
echo "  Site:     http://localhost:5173"
echo "  Admin:    http://localhost:8000/admin"
echo "  API:      http://localhost:8000/api/v1/categories"
echo
echo "  Logs:     $LOG_DIR/{backend,frontend}.log"
echo "  Press Ctrl+C to stop both servers."
echo

# Tail both logs so the user sees activity in one terminal
tail -f "$LOG_DIR/backend.log" "$LOG_DIR/frontend.log"

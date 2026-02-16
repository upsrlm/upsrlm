#!/bin/bash
# DEPLOYMENT SECURITY CHECKLIST
# Run this before deploying to production
# Ensure all checks pass before going live

set -e

echo "======================================"
echo "UPSRLM Production Deployment Checklist"
echo "======================================"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Counters
PASSED=0
FAILED=0
WARNINGS=0

check_file_exists() {
    if [ -f "$1" ]; then
        echo -e "${GREEN}✓${NC} $2"
        ((PASSED++))
        return 0
    else
        echo -e "${RED}✗${NC} $2 - File not found: $1"
        ((FAILED++))
        return 1
    fi
}

check_env_var() {
    if grep -q "^$1=" .env 2>/dev/null; then
        value=$(grep "^$1=" .env | cut -d'=' -f2)
        if [ -z "$value" ]; then
            echo -e "${YELLOW}⚠${NC} $2 - Environment variable '$1' is empty"
            ((WARNINGS++))
            return 1
        else
            echo -e "${GREEN}✓${NC} $2"
            ((PASSED++))
            return 0
        fi
    else
        echo -e "${RED}✗${NC} $2 - Environment variable '$1' not found"
        ((FAILED++))
        return 1
    fi
}

check_config_value() {
    if grep -q "$2" "$1" 2>/dev/null; then
        echo -e "${GREEN}✓${NC} $3"
        ((PASSED++))
        return 0
    else
        echo -e "${RED}✗${NC} $3"
        ((FAILED++))
        return 1
    fi
}

echo ""
echo "1. ENVIRONMENT VARIABLES"
echo "========================"
check_file_exists .env ".env file exists (not in git)"
check_env_var "DB_HOST" "Database host configured"
check_env_var "DB_USER" "Database user configured"
check_env_var "DB_PASSWORD" "Database password configured"
check_env_var "DB_NAME" "Database name configured"
check_env_var "COOKIE_VALIDATION_KEY" "Cookie validation key set"
check_env_var "JWT_SECRET" "JWT secret key set"
check_env_var "MAIL_HOST" "Mail server configured"
check_env_var "MAIL_USERNAME" "Mail username configured"
check_env_var "MAIL_PASSWORD" "Mail password configured"

echo ""
echo "2. CONFIGURATION FILES"
echo "======================"
check_file_exists "common/config/main.php" "Main config exists"
check_file_exists "common/config/env.php" "Environment loader exists"

echo ""
echo "3. SECURITY CONFIGURATION"
echo "=============================="
echo ""
echo "Checking common/config/main.php:"

if grep -q "REPLACE_WITH_RANDOM_SECRET" common/config/main.php; then
    echo -e "${RED}✗${NC} Cookie validation key is still placeholder"
    ((FAILED++))
else
    echo -e "${GREEN}✓${NC} Cookie validation key is not placeholder"
    ((PASSED++))
fi

if grep -q "'key'.*=>.*'secret'" common/config/main.php; then
    echo -e "${RED}✗${NC} JWT key is still set to 'secret'"
    ((FAILED++))
else
    echo -e "${GREEN}✓${NC} JWT key is not hardcoded"
    ((PASSED++))
fi

if grep -q "enableCsrfValidation.*false" common/config/main.php | grep -v "beforeAction"; then
    echo -e "${RED}✗${NC} CSRF validation appears to be globally disabled"
    ((FAILED++))
else
    echo -e "${GREEN}✓${NC} CSRF validation not globally disabled"
    ((PASSED++))
fi

if grep -q "'verify_peer'.*false" common/config/main.php; then
    echo -e "${RED}✗${NC} SSL peer verification is disabled in mail config"
    ((FAILED++))
else
    echo -e "${GREEN}✓${NC} SSL peer verification is enabled"
    ((PASSED++))
fi

echo ""
echo "4. APPLICATION STRUCTURE"
echo "========================"
check_file_exists "YII_ENV=prod" ".env has YII_ENV=prod" || {
    if grep -q "YII_ENV=prod" .env 2>/dev/null; then
        echo -e "${GREEN}✓${NC} YII_ENV set to prod"
        ((PASSED++))
    else
        echo -e "${YELLOW}⚠${NC} YII_ENV not set to prod (might be dev)"
        ((WARNINGS++))
    fi
}

if [ -d "runtime" ]; then
    if [ -w "runtime" ]; then
        echo -e "${GREEN}✓${NC} runtime directory is writable"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} runtime directory is not writable"
        ((FAILED++))
    fi
fi

if [ -d "web/assets" ]; then
    if [ -w "web/assets" ]; then
        echo -e "${GREEN}✓${NC} web/assets directory is writable"
        ((PASSED++))
    else
        echo -e "${RED}✗${NC} web/assets directory is not writable"
        ((FAILED++))
    fi
fi

echo ""
echo "5. TESTING"
echo "=========="
if command -v vendor/bin/codecept &> /dev/null; then
    echo -e "${GREEN}✓${NC} Codeception test runner found"
    ((PASSED++))
    
    echo ""
    echo "Running tests..."
    if vendor/bin/codecept run --quiet 2>/dev/null; then
        echo -e "${GREEN}✓${NC} All tests passed"
        ((PASSED++))
    else
        echo -e "${YELLOW}⚠${NC} Some tests failed - review before deployment"
        ((WARNINGS++))
    fi
else
    echo -e "${YELLOW}⚠${NC} Codeception not installed - tests cannot run"
    ((WARNINGS++))
fi

echo ""
echo "6. DEPENDENCIES"
echo "==============="
if [ -d "vendor" ]; then
    echo -e "${GREEN}✓${NC} Composer dependencies installed"
    ((PASSED++))
else
    echo -e "${RED}✗${NC} Composer dependencies not installed (run: composer install)"
    ((FAILED++))
fi

echo ""
echo "7. FILE PERMISSIONS"
echo "==================="
# Check that .env has restricted permissions
if [ -f .env ]; then
    perms=$(stat -f %A .env 2>/dev/null || stat -c %a .env 2>/dev/null)
    if [[ "$perms" == *"600"* ]] || [[ "$perms" == *"640"* ]]; then
        echo -e "${GREEN}✓${NC} .env file has restrictive permissions (600/640)"
        ((PASSED++))
    else
        echo -e "${YELLOW}⚠${NC} .env file permissions: $perms (should be 600 or 640)"
        ((WARNINGS++))
    fi
fi

chmod 755 runtime 2>/dev/null || true
chmod 755 web/assets 2>/dev/null || true

echo ""
echo "======================================"
echo "SUMMARY"
echo "======================================"
echo -e "✓ Passed:  ${GREEN}$PASSED${NC}"
echo -e "⚠ Warnings: ${YELLOW}$WARNINGS${NC}"
echo -e "✗ Failed:  ${RED}$FAILED${NC}"
echo ""

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}All critical checks passed!${NC}"
    echo ""
    echo "Next steps:"
    echo "1. Run migrations: ./yii migrate"
    echo "2. Clear cache: ./yii cache/flush-all"
    echo "3. Configure web server (nginx/Apache)"
    echo "4. Set up SSL certificate"
    echo "5. Configure backup strategy"
    echo "6. Test critical user flows"
    echo "7. Monitor logs in production"
    echo ""
    exit 0
else
    echo -e "${RED}Critical checks failed!${NC}"
    echo "Fix the issues above before deploying to production."
    echo ""
    exit 1
fi

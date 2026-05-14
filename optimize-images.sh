#!/bin/bash

#########################################################################
# Image Optimization Script for ShiftTech Website
# This script optimizes all images for production deployment
#
# Prerequisites:
#   - jpegoptim: sudo apt-get install jpegoptim
#   - webp: sudo apt-get install webp
#   - pngquant: sudo apt-get install pngquant
#
# Usage:
#   chmod +x optimize-images.sh
#   ./optimize-images.sh
#########################################################################

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Counter variables
OPTIMIZED_COUNT=0
WEBP_COUNT=0
ERROR_COUNT=0

echo -e "${BLUE}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   ShiftTech Image Optimization Script                 ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════╝${NC}"
echo ""

# Check if required tools are installed
echo -e "${YELLOW}[1/5] Checking dependencies...${NC}"

MISSING_DEPS=()

if ! command -v jpegoptim &> /dev/null; then
    MISSING_DEPS+=("jpegoptim")
fi

if ! command -v cwebp &> /dev/null; then
    MISSING_DEPS+=("webp")
fi

if ! command -v pngquant &> /dev/null; then
    MISSING_DEPS+=("pngquant")
fi

if [ ${#MISSING_DEPS[@]} -gt 0 ]; then
    echo -e "${RED}✗ Missing dependencies: ${MISSING_DEPS[*]}${NC}"
    echo ""
    echo -e "${YELLOW}Please install missing dependencies:${NC}"
    echo -e "  ${GREEN}sudo apt-get update${NC}"
    echo -e "  ${GREEN}sudo apt-get install ${MISSING_DEPS[*]}${NC}"
    echo ""
    exit 1
else
    echo -e "${GREEN}✓ All dependencies installed${NC}"
fi

echo ""

# Backup original images
echo -e "${YELLOW}[2/5] Creating backup...${NC}"
BACKUP_DIR="public/assets/images_backup_$(date +%Y%m%d_%H%M%S)"

if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
    cp -r public/assets/images/* "$BACKUP_DIR/"
    echo -e "${GREEN}✓ Backup created at: $BACKUP_DIR${NC}"
else
    echo -e "${YELLOW}⚠ Backup directory already exists, skipping...${NC}"
fi

echo ""

# Optimize JPG images
echo -e "${YELLOW}[3/5] Optimizing JPG images...${NC}"
echo -e "${BLUE}→ Finding JPG images in public/assets/images...${NC}"

JPG_COUNT=$(find public/assets/images -name "*.jpg" -o -name "*.jpeg" | wc -l)
echo -e "${BLUE}→ Found $JPG_COUNT JPG images${NC}"

if [ $JPG_COUNT -gt 0 ]; then
    while IFS= read -r img; do
        # Get original size
        ORIGINAL_SIZE=$(du -k "$img" | cut -f1)

        # Optimize JPG
        jpegoptim --max=85 --strip-all "$img" &> /dev/null

        # Get new size
        NEW_SIZE=$(du -k "$img" | cut -f1)

        # Calculate savings
        if [ $ORIGINAL_SIZE -gt 0 ]; then
            SAVINGS=$((100 - (NEW_SIZE * 100 / ORIGINAL_SIZE)))
            echo -e "${GREEN}  ✓ $(basename "$img"): ${ORIGINAL_SIZE}KB → ${NEW_SIZE}KB (${SAVINGS}% saved)${NC}"
            ((OPTIMIZED_COUNT++))
        fi
    done < <(find public/assets/images -name "*.jpg" -o -name "*.jpeg")

    echo -e "${GREEN}✓ Optimized $OPTIMIZED_COUNT JPG images${NC}"
else
    echo -e "${YELLOW}⚠ No JPG images found${NC}"
fi

echo ""

# Convert to WebP format
echo -e "${YELLOW}[4/5] Converting images to WebP format...${NC}"
echo -e "${BLUE}→ Converting JPG images...${NC}"

if [ $JPG_COUNT -gt 0 ]; then
    while IFS= read -r img; do
        OUTPUT="${img%.*}.webp"

        # Convert to WebP
        if cwebp -q 85 "$img" -o "$OUTPUT" &> /dev/null; then
            ORIGINAL_SIZE=$(du -k "$img" | cut -f1)
            WEBP_SIZE=$(du -k "$OUTPUT" | cut -f1)
            SAVINGS=$((100 - (WEBP_SIZE * 100 / ORIGINAL_SIZE)))
            echo -e "${GREEN}  ✓ $(basename "$OUTPUT"): ${ORIGINAL_SIZE}KB → ${WEBP_SIZE}KB (${SAVINGS}% saved)${NC}"
            ((WEBP_COUNT++))
        else
            echo -e "${RED}  ✗ Failed: $(basename "$img")${NC}"
            ((ERROR_COUNT++))
        fi
    done < <(find public/assets/images -name "*.jpg" -o -name "*.jpeg")
fi

echo -e "${BLUE}→ Converting PNG images...${NC}"
PNG_COUNT=$(find public/assets/images -name "*.png" | wc -l)

if [ $PNG_COUNT -gt 0 ]; then
    while IFS= read -r img; do
        OUTPUT="${img%.*}.webp"

        # Skip if already has WebP
        if [ -f "$OUTPUT" ]; then
            continue
        fi

        # Convert to WebP
        if cwebp -q 85 "$img" -o "$OUTPUT" &> /dev/null; then
            ORIGINAL_SIZE=$(du -k "$img" | cut -f1)
            WEBP_SIZE=$(du -k "$OUTPUT" | cut -f1)
            SAVINGS=$((100 - (WEBP_SIZE * 100 / ORIGINAL_SIZE)))
            echo -e "${GREEN}  ✓ $(basename "$OUTPUT"): ${ORIGINAL_SIZE}KB → ${WEBP_SIZE}KB (${SAVINGS}% saved)${NC}"
            ((WEBP_COUNT++))
        else
            echo -e "${RED}  ✗ Failed: $(basename "$img")${NC}"
            ((ERROR_COUNT++))
        fi
    done < <(find public/assets/images -name "*.png")
fi

echo -e "${GREEN}✓ Created $WEBP_COUNT WebP images${NC}"
echo ""

# Optimize PNG images
echo -e "${YELLOW}[5/5] Optimizing PNG images...${NC}"
echo -e "${BLUE}→ Found $PNG_COUNT PNG images${NC}"

PNG_OPTIMIZED=0

if [ $PNG_COUNT -gt 0 ]; then
    while IFS= read -r img; do
        # Get original size
        ORIGINAL_SIZE=$(du -k "$img" | cut -f1)

        # Optimize PNG
        pngquant --quality=65-80 --ext .png --force "$img" &> /dev/null

        # Get new size
        NEW_SIZE=$(du -k "$img" | cut -f1)

        # Calculate savings
        if [ $ORIGINAL_SIZE -gt $NEW_SIZE ]; then
            SAVINGS=$((100 - (NEW_SIZE * 100 / ORIGINAL_SIZE)))
            echo -e "${GREEN}  ✓ $(basename "$img"): ${ORIGINAL_SIZE}KB → ${NEW_SIZE}KB (${SAVINGS}% saved)${NC}"
            ((PNG_OPTIMIZED++))
        fi
    done < <(find public/assets/images -name "*.png")

    echo -e "${GREEN}✓ Optimized $PNG_OPTIMIZED PNG images${NC}"
else
    echo -e "${YELLOW}⚠ No PNG images found${NC}"
fi

echo ""
echo -e "${BLUE}╔════════════════════════════════════════════════════════╗${NC}"
echo -e "${BLUE}║   Optimization Complete!                              ║${NC}"
echo -e "${BLUE}╚════════════════════════════════════════════════════════╝${NC}"
echo ""
echo -e "${GREEN}Summary:${NC}"
echo -e "  • JPG images optimized: ${GREEN}$OPTIMIZED_COUNT${NC}"
echo -e "  • PNG images optimized: ${GREEN}$PNG_OPTIMIZED${NC}"
echo -e "  • WebP images created: ${GREEN}$WEBP_COUNT${NC}"
echo -e "  • Errors encountered: ${RED}$ERROR_COUNT${NC}"
echo -e "  • Backup location: ${YELLOW}$BACKUP_DIR${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo -e "  1. Update your Blade templates to use WebP images with fallbacks"
echo -e "  2. Test the website to ensure all images load correctly"
echo -e "  3. If everything works, you can delete the backup folder"
echo ""
echo -e "${BLUE}Example usage in Blade templates:${NC}"
echo -e '  <picture>'
echo -e '    <source srcset="/assets/images/thumbs/meeting.webp" type="image/webp">'
echo -e '    <img src="/assets/images/thumbs/meeting.jpg" alt="Meeting" loading="lazy">'
echo -e '  </picture>'
echo ""

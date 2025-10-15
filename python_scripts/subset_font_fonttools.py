#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
字體子集生成腳本 (使用 fontTools 替代 fontforge)
從完整字體中提取指定文字的字符
支持大型字體文件，不會崩潰

安裝方法：
    brew install fonttools
    或
    pip3 install --user --break-system-packages fonttools brotli

用法:
    python3 subset_font_fonttools.py <輸入字體> <輸出字體> <要保留的文字檔案>

範例:
    python3 subset_font_fonttools.py input.ttf output.ttf keep_chars.txt
"""

import sys
import os

def main():
    if len(sys.argv) < 4:
        print("[ERROR] Insufficient arguments", file=sys.stderr)
        print("Usage: python3 subset_font_fonttools.py <input_font> <output_font> <keep_chars_file>", file=sys.stderr)
        sys.exit(1)

    input_font_path = sys.argv[1]
    output_font_path = sys.argv[2]
    keep_chars_path = sys.argv[3]

    # 檢查輸入
    if not os.path.exists(input_font_path):
        print(f"[ERROR] Input font not found: {input_font_path}", file=sys.stderr)
        sys.exit(1)

    if not os.path.exists(keep_chars_path):
        print(f"[ERROR] Keep chars file not found: {keep_chars_path}", file=sys.stderr)
        sys.exit(1)

    # 確保輸出目錄存在
    output_dir = os.path.dirname(output_font_path)
    if output_dir and not os.path.exists(output_dir):
        os.makedirs(output_dir, exist_ok=True)

    try:
        # 讀取要保留的文字
        with open(keep_chars_path, "r", encoding="utf-8") as f:
            keep_text = f.read().strip()

        if not keep_text:
            print("[ERROR] keep_chars file is empty!", file=sys.stderr)
            sys.exit(1)

        print(f"[INFO] Processing font: {input_font_path}")
        print(f"[INFO] Text length: {len(keep_text)} characters")
        
        # 建立要保留的 Unicode 集合
        unicodes = set(ord(char) for char in keep_text)
        
        print(f"[INFO] Unique characters: {len(unicodes)}")
        
        # 嘗試導入 fontTools
        try:
            from fontTools import subset
            from fontTools.ttLib import TTFont
        except ImportError:
            print("[ERROR] fontTools not installed!", file=sys.stderr)
            print("Please install: brew install fonttools", file=sys.stderr)
            print("Or: pip3 install --user --break-system-packages fonttools brotli", file=sys.stderr)
            sys.exit(1)
        
        # 載入字體
        font = TTFont(input_font_path)
        
        # 創建子集器
        subsetter = subset.Subsetter()
        
        # 設置選項
        subsetter.options = subset.Options()
        subsetter.options.retain_gids = False
        subsetter.options.notdef_glyph = True
        subsetter.options.notdef_outline = True
        subsetter.options.recommended_glyphs = True
        subsetter.options.recalc_bounds = True
        subsetter.options.recalc_timestamp = True
        subsetter.options.canonical_order = True
        
        # 設置要保留的字符
        subsetter.populate(unicodes=unicodes)
        
        # 執行子集化
        subsetter.subset(font)
        
        # 保存字體
        font.save(output_font_path)
        font.close()
        
        # 輸出資訊
        output_size = os.path.getsize(output_font_path) / 1024
        print(f"[SUCCESS] Font saved: {output_font_path}")
        print(f"[INFO] File size: {output_size:.1f} KB")
        print(f"[INFO] Kept glyphs: {len(unicodes)}")
        
        sys.exit(0)

    except Exception as e:
        print(f"[ERROR] {str(e)}", file=sys.stderr)
        import traceback
        traceback.print_exc(file=sys.stderr)
        sys.exit(1)

if __name__ == '__main__':
    main()


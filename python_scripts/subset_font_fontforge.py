#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
字體子集生成腳本 (使用 FontForge)
從完整字體中提取指定文字的字符

用法:
    python3 subset_font_fontforge.py <輸入字體> <輸出字體> <要保留的文字檔案>

範例:
    python3 subset_font_fontforge.py input.ttf output.ttf keep_chars.txt
"""

import fontforge
import sys
import os

def main():
    if len(sys.argv) < 4:
        print("[ERROR] Insufficient arguments", file=sys.stderr)
        print("Usage: python3 subset_font_fontforge.py <input_font> <output_font> <keep_chars_file>", file=sys.stderr)
        sys.exit(1)

    input_font_path = sys.argv[1]
    output_font_path = sys.argv[2]
    keep_chars_path = sys.argv[3]

    if not os.path.exists(input_font_path):
        print(f"[ERROR] Input font not found: {input_font_path}", file=sys.stderr)
        sys.exit(1)

    if not os.path.exists(keep_chars_path):
        print(f"[ERROR] Keep chars file not found: {keep_chars_path}", file=sys.stderr)
        sys.exit(1)

    output_dir = os.path.dirname(output_font_path)
    if output_dir and not os.path.exists(output_dir):
        os.makedirs(output_dir, exist_ok=True)

    try:
        with open(keep_chars_path, "r", encoding="utf-8") as f:
            keep_chars = set(f.read().strip())

        if not keep_chars:
            print("[ERROR] keep_chars.txt is empty, no glyphs will be kept!", file=sys.stderr)
            sys.exit(1)

        font = fontforge.open(input_font_path)
        print(f"[INFO] Processing font: {input_font_path}")

        keep_glyphs = set()

        for char in keep_chars:
            try:
                unicode_val = ord(char)
                font.selection.select(("unicode",), unicode_val)
                selected_glyphs = [g.glyphname for g in font.selection.byGlyphs]
                if selected_glyphs:
                    keep_glyphs.update(selected_glyphs)
            except Exception:
                pass

        print(f"[INFO] Glyphs to keep: {len(keep_glyphs)}")

        removed_count = 0
        for glyph in list(font.glyphs()):
            if glyph.glyphname != ".notdef" and glyph.glyphclass != "mark" and glyph.glyphname not in keep_glyphs:
                font.removeGlyph(glyph)
                removed_count += 1

        print(f"[INFO] Removed {removed_count} glyphs")

        # 🚀 這兩行是關鍵修正！
        font.encoding = "UnicodeFull"  # 重建 Unicode 對應表
        font.selection.none()          # 清空選擇，避免影響輸出

        # 🚀 使用 OpenType flag 生成子集字體
        font.generate(output_font_path, flags=("opentype",))

        output_size = os.path.getsize(output_font_path) / 1024
        print(f"[SUCCESS] Font saved: {output_font_path}")
        print(f"[INFO] File size: {output_size:.1f} KB")
        print(f"[INFO] Kept glyphs: {len(keep_glyphs)}")

        font.close()
        sys.exit(0)

    except Exception as e:
        print(f"[ERROR] {str(e)}", file=sys.stderr)
        import traceback
        traceback.print_exc(file=sys.stderr)
        sys.exit(1)

if __name__ == '__main__':
    main()

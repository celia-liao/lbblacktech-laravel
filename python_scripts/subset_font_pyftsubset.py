#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
字體子集生成腳本 (使用 pyftsubset 命令行工具)
從完整字體中提取指定文字的字符

用法:
    python3 subset_font_pyftsubset.py <輸入字體> <輸出字體> <要保留的文字檔案>

範例:
    python3 subset_font_pyftsubset.py input.ttf output.ttf keep_chars.txt
"""

import sys
import os
import subprocess
import shutil
import traceback

def main():
    if len(sys.argv) < 4:
        print("[ERROR] Insufficient arguments", file=sys.stderr)
        print("Usage: python3 subset_font_pyftsubset.py <input_font> <output_font> <keep_chars_file>", file=sys.stderr)
        sys.exit(1)

    input_font_path = sys.argv[1]
    output_font_path = sys.argv[2]
    keep_chars_path = sys.argv[3]

    # 檢查輸入檔
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
        unicodes = sorted(set(ord(char) for char in keep_text))
        unicode_str = ','.join(f'U+{u:04X}' for u in unicodes)

        print(f"[INFO] Unique characters: {len(unicodes)}")

        # 找 pyftsubset 路徑
        pyftsubset_path = shutil.which("pyftsubset")
        if not pyftsubset_path:
            print("[ERROR] pyftsubset not found in PATH. Please install fonttools.", file=sys.stderr)
            sys.exit(1)

        # 準備命令
        cmd = [
            pyftsubset_path,
            input_font_path,
            f'--output-file={output_font_path}',
            f'--unicodes={unicode_str}',
            '--layout-features=*',
            '--glyph-names',
            '--legacy-cmap',
            '--symbol-cmap',
            '--name-IDs=*',
            '--name-languages=*',
            '--notdef-glyph',
            '--notdef-outline',
            '--recommended-glyphs',
            '--no-hinting',
            '--desubroutinize'
        ]

        # 執行命令
        result = subprocess.run(cmd, capture_output=True, text=True)

        if result.returncode != 0:
            print(f"[ERROR] pyftsubset failed", file=sys.stderr)
            print(result.stderr, file=sys.stderr)
            sys.exit(1)

        # 檢查輸出檔案
        if not os.path.exists(output_font_path):
            print("[ERROR] Output font file was not created", file=sys.stderr)
            sys.exit(1)

        # 輸出資訊
        output_size = os.path.getsize(output_font_path) / 1024
        print(f"[SUCCESS] Font saved: {output_font_path}")
        print(f"[INFO] File size: {output_size:.1f} KB")
        print(f"[INFO] Kept glyphs: {len(unicodes)}")

        sys.exit(0)

    except Exception as e:
        print(f"[ERROR] {str(e)}", file=sys.stderr)
        traceback.print_exc(file=sys.stderr)
        sys.exit(1)


if __name__ == '__main__':
    main()

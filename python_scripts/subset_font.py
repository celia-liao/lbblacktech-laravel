#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
字體子集生成腳本
使用 fonttools 從完整字體中提取指定文字的字符

用法:
    python3 subset_font.py <輸入字體> <輸出字體> <要保留的文字>

範例:
    python3 subset_font.py input.ttf output.ttf "你好世界"
"""

import sys
import os
from fontTools import subset

def main():
    if len(sys.argv) < 4:
        print("錯誤: 參數不足", file=sys.stderr)
        print("用法: python3 subset_font.py <輸入字體> <輸出字體> <要保留的文字>", file=sys.stderr)
        sys.exit(1)

    input_font = sys.argv[1]
    output_font = sys.argv[2]
    text = sys.argv[3]

    # 檢查輸入檔案是否存在
    if not os.path.exists(input_font):
        print(f"錯誤: 輸入字體不存在: {input_font}", file=sys.stderr)
        sys.exit(1)

    # 確保輸出目錄存在
    output_dir = os.path.dirname(output_font)
    if output_dir and not os.path.exists(output_dir):
        os.makedirs(output_dir, exist_ok=True)

    try:
        # 創建 subset 選項
        options = subset.Options()
        
        # 設置選項
        options.layout_features = ['*']  # 保留所有 layout features
        options.name_IDs = ['*']         # 保留所有 name IDs
        options.name_legacy = True       # 保留 legacy name table
        options.name_languages = ['*']   # 保留所有語言
        options.no_hinting = True        # 移除 hinting（減小檔案大小）
        options.desubroutinize = True    # 優化 CFF 字體
        
        # 根據輸出格式設置 flavor
        if output_font.endswith('.woff2'):
            options.flavor = 'woff2'
        elif output_font.endswith('.woff'):
            options.flavor = 'woff'
        
        # 創建 Subsetter
        subsetter = subset.Subsetter(options=options)
        
        # 載入字體
        font = subset.load_font(input_font, options)
        
        # 設置要保留的文字
        subsetter.populate(text=text)
        
        # 執行 subset
        subsetter.subset(font)
        
        # 儲存輸出
        subset.save_font(font, output_font, options)
        
        # 輸出成功訊息
        output_size = os.path.getsize(output_font)
        output_size_kb = output_size / 1024
        print(f"成功生成字體子集: {output_font}")
        print(f"檔案大小: {output_size_kb:.1f} KB")
        print(f"字符數量: {len(text)}")
        
        sys.exit(0)

    except Exception as e:
        print(f"錯誤: {str(e)}", file=sys.stderr)
        import traceback
        traceback.print_exc(file=sys.stderr)
        sys.exit(1)

if __name__ == '__main__':
    main()


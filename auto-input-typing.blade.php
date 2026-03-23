  <div class="mb-5">
       <label for="content" class="block font-semibold mb-2 text-gray-700">質問したい内容</label>
       @error('content')
           <p class="text-red-500 text-sm mt-1">※必須項目です</p>
       @enderror
       <div x-data="formatter()">{{-- x-data="formatter()"で、このdivの中だけで使えるJSの世界を作る --}}
           <textarea x-model="result" id="content" name="content" rows="4"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">{{ old('content') }}</textarea>

           <!-- 開くボタン -->
           <button x-on:click="open = true" type="button">自動入力する</button>

           <!-- モーダル -->
           <div x-show="open" class="fixed inset-0 bg-black/30 flex items-center justify-center">

               <div class="bg-white p-5 w-[300px] rounded-lg shadow-lg">

                   <input type="text" x-model="input1" x-on:input="format" placeholder="504点 45.8 25回"
                       class="w-full border rounded px-2 py-1 mb-3">
                   <input type="text" x-model="input2" x-on:input="format" placeholder="A 95.8 25回 TRYET"
                       class="w-full border rounded px-2 py-1 mb-3">
                   <p x-show="isValid" class="text-green-500">文字列を自動入力しています</p>
                   <p x-show="!isValid" class="text-blue-800">有効な文字列を入力してください</p>
                   <button x-on:click="open = false" type="button"
                       class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">閉じる</button>
               </div>
           </div>

       </div>
   </div>
   @push('scripts')
       <script>
           function formatter() {
               return {
                   open: false,
                   input1: '',
                   input2: '',
                   result: '',
                   isValid: false,
                   parseSushi(input) {
                       // 正規化
                       let normalized = input
                           .replace(/,/g, ' ')
                           .replace(/　/g, ' ')
                           .trim()
                       // 分割
                       let parts = normalized.split(/\s+/)

                       if (parts.length === 3) {
                           let result1 = `点数:${parts[0]} WPM:${parts[1]} ミス:${parts[2]}`

                           return result1
                       }
                       return ''
                   },
                   parseETyping(input) {
                       // 正規化
                       let normalized = input
                           .replace(/,/g, ' ')
                           .replace(/　/g, ' ')
                           .trim()
                       // 分割
                       let parts = normalized.split(/\s+/)

                       if (parts.length === 4) {
                           let result2 = `ランク:${parts[0]} 正解率:${parts[1]} ミス:${parts[2]} 間違いやすいキー:${parts[3]}`

                           return result2
                       }
                       return ''
                   },
                   format() {

                       let result1 = this.parseSushi(this.input1)
                       let result2 = this.parseETyping(this.input2)

                       if (result1 && result2) {
                           this.result = `寿司打 \n ${result1} \n \n e-タイピング \n ${result2}`

                           this.isValid = true
                           // console.log(this.result)
                       } else {
                           this.isValid = false

                           // console.log('フォーマットエラー')
                       }
                   }
               }
           }
       </script>
   @endpush




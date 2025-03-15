<x-guest-layout>
    <div class="p-6">

        <x-heading>
            {{ __('Select Recurring Categories') }}
        </x-heading>

        <div class="mt-6 ">
            <form action="{{route('addCategory')}}" method="post">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    @foreach($categories as $category)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="categories[]" value="{{ $category->name }}" class="rounded border-gray-300 text-[#3268a8] focus:ring-[#3268a8]">
                            <span class="ms-2">{{ $category->name }}</span>
                        </label>

                        <input type="hidden" name="predefined[]" value="{{ $category->name }}">
                    @endforeach
                </div>


                <ul id="categoryInfo" class="p-0">

                </ul>
                <div class="flex">
                    <input id="category" class="block mt-1 w-fit" type="text" name="category" placeholder="More Category" />
                    <button type="button"  onclick="addCategory()" class="ms-2 text-xl" style="color: #3268a8">+</button>
                </div>

                <div id="error">
                    {{$error}}
                </div>

                <div id="new_categories[]">

                </div>

                <x-primary-button type="submit" class="mt-4">Add</x-primary-button>
            </form>
        </div>
    </div>
    <script>
        let catArr=[];

        let predefined = [];
        let predefinedInputs = document.querySelectorAll('input[name="predefined[]"]');

        for (let i = 0; i < predefinedInputs.length; i++) {
            predefined.push(predefinedInputs[i].value);
        }

        console.log(predefined)
        function addCategory(){
            let category=document.getElementById('category').value;

            if(category === ''){
               return document.getElementById('error').innerHTML="Category Cant be empty"
            }else{
                if (catArr.includes(category)) {
                    document.getElementById('category').value = '';
                    return document.getElementById('error').innerHTML = "Category Already Added";
                }

                if(predefined.includes(category)){
                    document.getElementById('category').value = '';
                    return document.getElementById('error').innerHTML = "Check in the Category Checkbox";
                }

                catArr.push(category)

                let li = document.createElement('li');

                li.textContent = category;

                let remove = document.createElement('button');
                remove.textContent = 'X';
                remove.onclick = function () {
                    removeCategory(li, category);
                };

                li.append(remove);

                document.getElementById('categoryInfo').appendChild(li);

                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'new_categories[]';
                hiddenInput.value = category;

                document.getElementById('new_categories[]').append(hiddenInput)
                document.getElementById('category').value = '';
            }
        }

        function removeCategory(listItem, category) {
            catArr = catArr.filter(item => item !== category);

            document.getElementById('categoryInfo').removeChild(listItem);
        }
    </script>
</x-guest-layout>

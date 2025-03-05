<x-guest-layout>
    <div class="p-6">
        <h2 class="text-lg font-medium dark:text-gray-100">
            {{ __('Select Recurring Categories') }}
        </h2>

        <div class="mt-6 ">
            <form action="{{route('addCategory')}}" method="post">
                @csrf
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox" name="categories[]" value="{{ $category->name }}">
                        {{ $category->name }}

                        <div class="predefined[]">
                            <input type="hidden" name="predefined[]" value="{{$category->name}}">
                        </div>
                    </label>
                @endforeach

                <ul id="categoryInfo" class="p-0">

                </ul>
                <div>
                    <input type="text" name="new_categories" placeholder="More Category" id="category">
                    <button type="button"  onclick="addCategory()">+</button>
                </div>

                <div id="error">
                    {{$error}}
                </div>

                <div id="new_categories[]">

                </div>

                <button type="submit">Add</button>
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

@props(['accordion' => false])
<ul
  {{ $attributes->merge(['class' => 'sidebar-menu tree']) }}
  x-data="{
        accordion: {{ $accordion ? 'true' : 'false' }},
        collapseAll() {
            if (!this.accordion) return;
            this.$el.querySelectorAll('.treeview-item').forEach(li => {
                const data = Alpine.$data(li);
                if (data) data.open = false;
            });
        }
    }"
  
>
  {{ $slot }}
</ul>
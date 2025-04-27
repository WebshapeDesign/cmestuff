<x-layouts.app :title="__('Vehicles')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">


    <flux:main container>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <flux:select size="sm" class="">
                        <option>Last 7 days</option>
                        <option>Last 14 days</option>
                        <option selected>Last 30 days</option>
                        <option>Last 60 days</option>
                        <option>Last 90 days</option>
                    </flux:select>

                    <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>

                    <flux:select size="sm" class="max-md:hidden">
                        <option selected>Previous period</option>
                        <option>Same period last year</option>
                        <option>Last month</option>
                        <option>Last quarter</option>
                        <option>Last 6 months</option>
                        <option>Last 12 months</option>
                    </flux:select>
                </div>

                <flux:separator vertical class="max-lg:hidden mx-2 my-2" />

                <div class="max-lg:hidden flex justify-start items-center gap-2">
                    <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>

                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">Amount</flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg" class="max-md:hidden">Status</flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">More filters...</flux:badge>
                </div>
            </div>

            <flux:tabs variant="segmented" class="w-auto! ml-2" size="sm">
                <flux:tab icon="list-bullet" icon:variant="outline" />
                <flux:tab icon="squares-2x2" icon:variant="outline" />
            </flux:tabs>
        </div>

        <div class="flex gap-6 mb-6">
            
                <div class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700">
                    <flux:subheading>Number of Vehicles</flux:subheading>

                    <flux:heading size="xl" class="mb-2">12</flux:heading>

                    <div class="flex items-center gap-1 font-medium text-sm">
                        
                    </div>

                    <div class="absolute top-0 right-0 pr-2 pt-2">
                        <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                    </div>
                </div>
            
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column></flux:table.column>
                <flux:table.column class="max-md:hidden">ID</flux:table.column>
                <flux:table.column class="max-md:hidden">Date</flux:table.column>
                <flux:table.column class="max-md:hidden">Status</flux:table.column>
                <flux:table.column><span class="max-md:hidden">Customer</span><div class="md:hidden w-6"></div></flux:table.column>
                <flux:table.column>Purchase</flux:table.column>
                <flux:table.column>Revenue</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
               
                    <flux:table.row>
                        <flux:table.cell class="pr-2"><flux:checkbox /></flux:table.cell>
                        <flux:table.cell class="max-md:hidden">ID</flux:table.cell>
                        <flux:table.cell class="max-md:hidden">Date</flux:table.cell>
                        <flux:table.cell class="max-md:hidden"><flux:badge :color="" size="sm" inset="top bottom">Status</flux:badge></flux:table.cell>
                        <flux:table.cell class="min-w-6">
                            <div class="flex items-center gap-2">
                                <flux:avatar src="this" size="xs" />
                                <span class="max-md:hidden">Customer</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="max-w-6 truncate">Purchase</flux:table.cell>
                        <flux:table.cell class="this" variant="strong">Revenue</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown position="bottom" align="end" offset="-15">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="document-text">View invoice</flux:menu.item>
                                    <flux:menu.item icon="receipt-refund">Refund</flux:menu.item>
                                    <flux:menu.item icon="archive-box" variant="danger">Archive</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                
            </flux:table.rows>
        </flux:table>

       
    </flux:main>
</div>
</x-layouts.app>
